<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TipoConsultaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TipoConsultaApiController extends Controller
{
    protected TipoConsultaService $tipoConsultaService;

    public function __construct(TipoConsultaService $tipoConsultaService)
    {
        $this->tipoConsultaService = $tipoConsultaService;
    }


    /**
     * @OA\Get(
     *     path="/api/tipos-consulta",
     *     tags={"Tipos de Consulta"},
     *     summary="Lista todos os tipos de consulta",
     *     description="Retorna todos os tipos de consulta cadastrados.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipos de consulta retornada com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     {
     *                         "id": 1,
     *                         "nome": "Consulta Cardiológica",
     *                         "duracao": 30,
     *                         "hora_inicio": "08:00:00",
     *                         "hora_fim": "18:00:00",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     },
     *                     {
     *                         "id": 2,
     *                         "nome": "Consulta Ortopédica",
     *                         "duracao": 45,
     *                         "hora_inicio": "09:00:00",
     *                         "hora_fim": "17:00:00",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     },
     *                     {
     *                         "id": 3,
     *                         "nome": "Consulta Dermatológica",
     *                         "duracao": 30,
     *                         "hora_inicio": "10:00:00",
     *                         "hora_fim": "16:00:00",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     },
     *                     {
     *                         "id": 4,
     *                         "nome": "Consulta Neurológica",
     *                         "duracao": 50,
     *                         "hora_inicio": "08:00:00",
     *                         "hora_fim": "15:30:00",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:19:39.000000Z"
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $tipos = $this->tipoConsultaService->listarTiposConsulta();

        return response()->json([
            'success' => true,
            'data' => $tipos
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/tipos-consulta/{id}",
     *     tags={"Tipos de Consulta"},
     *     summary="Busca um tipo de consulta pelo ID",
     *     description="Retorna um tipo de consulta específico.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de consulta",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de consulta encontrado.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     "id": 1,
     *                     "nome": "Consulta Cardiológica",
     *                     "duracao": 30,
     *                     "hora_inicio": "08:00:00",
     *                     "hora_fim": "18:00:00",
     *                     "created_at": "2026-07-22T23:07:45.000000Z",
     *                     "updated_at": "2026-07-22T23:07:45.000000Z"
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de consulta não encontrado."
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $tipoConsulta = $this->tipoConsultaService->buscarTipoConsultaPorId($id);

        if (!$tipoConsulta) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de consulta não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tipoConsulta
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/tipos-consulta",
     *     tags={"Tipos de Consulta"},
     *     summary="Cadastra um novo tipo de consulta",
     *     description="Cria um novo tipo de consulta no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome",
     *                 "duracao",
     *                 "especialidades",
     *                 "hora_inicio",
     *                 "hora_fim"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Consulta Cardiológica"
     *             ),
     *             @OA\Property(
     *                 property="duracao",
     *                 type="integer",
     *                 example=60
     *             ),
     *             @OA\Property(
     *                 property="especialidades",
     *                 type="string",
     *                 description="IDs das especialidades separados por vírgula",
     *                 example="1,3"
     *             ),
     *             @OA\Property(
     *                 property="hora_inicio",
     *                 type="string",
     *                 format="time",
     *                 example="08:00"
     *             ),
     *             @OA\Property(
     *                 property="hora_fim",
     *                 type="string",
     *                 format="time",
     *                 example="18:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tipo de consulta cadastrado com sucesso."
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

            $tipoConsulta = $this->tipoConsultaService->cadastrarTipoConsulta(
                $request->all()
            );

            return response()->json([
                'success' => true,
                'message' => 'Tipo de consulta cadastrado com sucesso.',
                'data' => $tipoConsulta
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
     *     path="/api/tipos-consulta/{id}",
     *     tags={"Tipos de Consulta"},
     *     summary="Atualiza um tipo de consulta",
     *     description="Atualiza os dados de um tipo de consulta existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de consulta",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome",
     *                 "duracao",
     *                 "especialidades",
     *                 "hora_inicio",
     *                 "hora_fim"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Cirurgia"
     *             ),
     *             @OA\Property(
     *                 property="duracao",
     *                 type="integer",
     *                 example=60
     *             ),
     *             @OA\Property(
     *                 property="especialidades",
     *                 type="string",
     *                 description="IDs das especialidades separados por vírgula",
     *                 example="1,3"
     *             ),
     *             @OA\Property(
     *                 property="hora_inicio",
     *                 type="string",
     *                 format="time",
     *                 example="08:30"
     *             ),
     *             @OA\Property(
     *                 property="hora_fim",
     *                 type="string",
     *                 format="time",
     *                 example="18:00"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de consulta atualizado com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de consulta não encontrado."
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

            $tipoConsulta = $this->tipoConsultaService->buscarTipoConsultaPorId($id);

            if (!$tipoConsulta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de consulta não encontrado.'
                ], 404);
            }

            $this->tipoConsultaService->atualizarTipoConsulta(
                $id,
                $request->all()
            );

            $tipoConsultaAtualizado = $this->tipoConsultaService->buscarTipoConsultaPorId($id);

            return response()->json([
                'success' => true,
                'message' => 'Tipo de consulta atualizado com sucesso.',
                'data' => $tipoConsultaAtualizado
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
     *     path="/api/tipos-consulta/{id}",
     *     tags={"Tipos de Consulta"},
     *     summary="Remove um tipo de consulta",
     *     description="Exclui um tipo de consulta pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do tipo de consulta",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de consulta removido com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de consulta não encontrado."
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->tipoConsultaService->deletarTipoConsulta($id);

        if (!$deleted) {

            return response()->json([
                'success' => false,
                'message' => 'Tipo de consulta não encontrado.'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'message' => 'Tipo de consulta removido com sucesso.'
        ], 200);
    }
}