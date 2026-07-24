<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MedicoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MedicoApiController extends Controller
{
    protected MedicoService $medicoService;

    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }


    /**
     * @OA\Get(
     *     path="/api/medicos",
     *     tags={"Médicos"},
     *     summary="Lista todos os médicos",
     *     description="Retorna todos os médicos cadastrados.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de médicos retornada com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     {
     *                         "id": 1,
     *                         "nome": "Dra. Ana Martins",
     *                         "crm": "CRM001",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *                     {
     *                         "id": 2,
     *                         "nome": "Dr. Carlos Souza",
     *                         "crm": "CRM002",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *                     {
     *                         "id": 3,
     *                         "nome": "Dr. Felipe Ramos",
     *                         "crm": "CRM003",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *                     {
     *                         "id": 4,
     *                         "nome": "Dra. Fernanda Lopes",
     *                         "crm": "CRM004",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *                     {
     *                         "id": 5,
     *                         "nome": "Dr. Ricardo Nunes",
     *                         "crm": "CRM005",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $medicos = $this->medicoService->listarMedicos();

        return response()->json([
            'success' => true,
            'data' => $medicos
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/medicos/{id}",
     *     tags={"Médicos"},
     *     summary="Busca um médico pelo ID",
     *     description="Retorna um médico específico pelo identificador.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do médico",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médico encontrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Médico não encontrado."
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $medico = $this->medicoService->buscarMedicoPorId($id);

        if (!$medico) {
            return response()->json([
                'success' => false,
                'message' => 'Médico não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $medico
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/medicos",
     *     tags={"Médicos"},
     *     summary="Cadastra um novo médico",
     *     description="Cria um novo médico vinculando uma ou mais especialidades.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome",
     *                 "crm",
     *                 "especialidades"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Dr. João Silva"
     *             ),
     *             @OA\Property(
     *                 property="crm",
     *                 type="string",
     *                 example="123456"
     *             ),
     *             @OA\Property(
     *                 property="especialidades",
     *                 type="string",
     *                 example="1,3,5",
     *                 description="IDs das especialidades separados por vírgula"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Médico cadastrado com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Médico cadastrado com sucesso.",
     *                 "data": {
     *                     "id": 1,
     *                     "nome": "Dr. João Silva",
     *                     "crm": "123456"
     *                 }
     *             }
     *         )
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

            $medico = $this->medicoService->cadastrarMedico($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Médico cadastrado com sucesso.',
                'data' => $medico
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
     *     path="/api/medicos/{id}",
     *     tags={"Médicos"},
     *     summary="Atualiza um médico",
     *     description="Atualiza os dados de um médico existente e suas especialidades.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do médico",
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
     *                 example="Dr. Carlos Souza"
     *             ),
     *             @OA\Property(
     *                 property="crm",
     *                 type="string",
     *                 example="654321"
     *             ),
     *             @OA\Property(
     *                 property="especialidades",
     *                 type="string",
     *                 example="2,4",
     *                 description="IDs das especialidades separados por vírgula"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médico atualizado com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Médico atualizado com sucesso.",
     *                 "data": {
     *                     "id": 1,
     *                     "nome": "Dr. Carlos Souza",
     *                     "crm": "654321"
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Médico não encontrado."
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

            $medico = $this->medicoService->buscarMedicoPorId($id);

            if (!$medico) {
                return response()->json([
                    'success' => false,
                    'message' => 'Médico não encontrado.'
                ], 404);
            }

            $this->medicoService->atualizarMedicos(
                $id,
                $request->all()
            );

            $medicoAtualizado = $this->medicoService->buscarMedicoPorId($id);

            return response()->json([
                'success' => true,
                'message' => 'Médico atualizado com sucesso.',
                'data' => $medicoAtualizado
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
     *     path="/api/medicos/{id}",
     *     tags={"Médicos"},
     *     summary="Remove um médico",
     *     description="Exclui um médico pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do médico",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Médico removido com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Médico não encontrado."
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->medicoService->deletarMedicos($id);

        if (!$deleted) {

            return response()->json([
                'success' => false,
                'message' => 'Médico não encontrado.'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'message' => 'Médico removido com sucesso.'
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/medicos/search",
     *     tags={"Médicos"},
     *     summary="Pesquisa médicos",
     *     description="Busca médicos pelo termo informado.",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         required=true,
     *         description="Nome ou termo de pesquisa",
     *         @OA\Schema(
     *             type="string",
     *             example="João"
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
        $result = $this->medicoService->buscar(
            $request->get('query')
        );

        return response()->json([
            'success' => true,
            'data' => $result
        ], 200);
    }
}