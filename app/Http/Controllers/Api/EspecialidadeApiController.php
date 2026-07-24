<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EspecialidadeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EspecialidadeApiController extends Controller
{
    protected EspecialidadeService $especialidadeService;

    public function __construct(EspecialidadeService $especialidadeService)
    {
        $this->especialidadeService = $especialidadeService;
    }

    /**
     * @OA\Get(
     *     path="/api/especialidades",
     *     tags={"Especialidades"},
     *     summary="Lista todas as especialidades",
     *     description="Retorna todas as especialidades cadastradas.",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de especialidades retornada com sucesso.",
     *
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     {
     *                         "id": 1,
     *                         "nome": "Clínico Geral",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     },
     *                     {
     *                         "id": 2,
     *                         "nome": "Ortopedia",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $especialidades = $this->especialidadeService->listarEspecialidades();

        return response()->json([
            'success' => true,
            'data' => $especialidades
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/especialidades/{id}",
     *     tags={"Especialidades"},
     *     summary="Busca uma especialidade pelo ID",
     *     description="Retorna uma especialidade específica.",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da especialidade",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Especialidade encontrada.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     "id": 1,
     *                     "nome": "Clínico Geral",
     *                     "created_at": "2026-07-22T23:07:45.000000Z",
     *                     "updated_at": "2026-07-22T23:07:45.000000Z"
     *                 }
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Especialidade não encontrada."
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $especialidade = $this->especialidadeService->buscarEspecialidadePorId($id);

        if (!$especialidade) {
            return response()->json([
                'success' => false,
                'message' => 'Especialidade não encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $especialidade
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/especialidades",
     *     tags={"Especialidades"},
     *     summary="Cadastra uma nova especialidade",
     *     description="Cria uma nova especialidade no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Cardiologia"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Especialidade cadastrada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação."
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $especialidade = $this->especialidadeService->cadastrarEspecialidade(
                $request->all()
            );

            return response()->json([
                'success' => true,
                'message' => 'Especialidade cadastrada com sucesso.',
                'data' => $especialidade
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }


    /**
     * @OA\Put(
     *     path="/api/especialidades/{id}",
     *     tags={"Especialidades"},
     *     summary="Atualiza uma especialidade",
     *     description="Atualiza os dados de uma especialidade existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da especialidade",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Neurologia"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Especialidade atualizada com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Especialidade não encontrada."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação."
     *     )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {

            $especialidade = $this->especialidadeService->buscarEspecialidadePorId($id);

            if (!$especialidade) {
                return response()->json([
                    'success' => false,
                    'message' => 'Especialidade não encontrada.'
                ], 404);
            }

            $this->especialidadeService->atualizarEspecialidade(
                $id,
                $request->all()
            );

            $especialidadeAtualizada = $this->especialidadeService->buscarEspecialidadePorId($id);

            return response()->json([
                'success' => true,
                'message' => 'Especialidade atualizada com sucesso.',
                'data' => $especialidadeAtualizada
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }


    /**
     * @OA\Delete(
     *     path="/api/especialidades/{id}",
     *     tags={"Especialidades"},
     *     summary="Remove uma especialidade",
     *     description="Exclui uma especialidade pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da especialidade",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Especialidade removida com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Especialidade não encontrada."
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->especialidadeService->deletarEspecialidade($id);

        if (!$deleted) {

            return response()->json([
                'success' => false,
                'message' => 'Especialidade não encontrada.'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'message' => 'Especialidade removida com sucesso.'
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/especialidades/search",
     *     tags={"Especialidades"},
     *     summary="Pesquisa especialidades",
     *     description="Busca especialidades pelo termo informado.",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Texto para pesquisa",
     *         @OA\Schema(
     *             type="string",
     *             example="Cardio"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resultado da pesquisa."
     *     )
     * )
     */
    public function search(Request $request): JsonResponse
    {
        $result = $this->especialidadeService->search($request->get('query'));

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}