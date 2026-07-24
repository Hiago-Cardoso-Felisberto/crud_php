<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ConsultaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConsultaApiController extends Controller
{
    protected ConsultaService $consultaService;

    public function __construct(ConsultaService $consultaService)
    {
        $this->consultaService = $consultaService;
    }

    /**
     * @OA\Get(
     *     path="/api/consultas",
     *     tags={"Consultas"},
     *     summary="Lista todas as consultas",
     *     description="Retorna uma lista com todas as consultas cadastradas.",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Consultas encontradas",
     *
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     {
     *                         "id": 20,
     *                         "paciente_id": 20,
     *                         "medico_id": 1,
     *                         "tipo_consulta_id": 1,
     *                         "data_atendimento": "2026-06-20T13:00:00.000000Z",
     *                         "valor_consulta": "180.00",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z",
     *
     *                         "paciente": {
     *                             "id": 20,
     *                             "nome": "Isabela Cardoso",
     *                             "cpf": "00011122234",
     *                             "data_nascimento": "1998-08-15T03:00:00.000000Z",
     *                             "telefone": "48900000009",
     *                             "created_at": "2026-07-22T23:07:46.000000Z",
     *                             "updated_at": "2026-07-22T23:07:46.000000Z"
     *                         },
     *
     *                         "medico": {
     *                             "id": 1,
     *                             "nome": "Dra. Ana Martins",
     *                             "crm": "CRM001",
     *                             "created_at": "2026-07-22T23:07:46.000000Z",
     *                             "updated_at": "2026-07-22T23:07:46.000000Z"
     *                         }
     *                     }
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $consultas = $this->consultaService->listarConsultas();

        return response()->json([
            'success' => true,
            'data' => $consultas
        ], 200);
    }


   /**
     * @OA\Get(
     *     path="/api/consultas/{id}",
     *     tags={"Consultas"},
     *     summary="Busca uma consulta pelo ID",
     *     description="Retorna uma consulta específica pelo seu identificador.",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da consulta",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Consulta encontrada",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "data": {
     *                     "id": 20,
     *                     "paciente_id": 20,
     *                     "medico_id": 1,
     *                     "tipo_consulta_id": 1,
     *                     "data_atendimento": "2026-06-20T13:00:00.000000Z",
     *                     "valor_consulta": "180.00",
     *                     "created_at": "2026-07-22T23:07:46.000000Z",
     *                     "updated_at": "2026-07-22T23:07:46.000000Z",
     *
     *                     "paciente": {
     *                         "id": 20,
     *                         "nome": "Isabela Cardoso",
     *                         "cpf": "00011122234",
     *                         "telefone": "48900000009",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *
     *                     "medico": {
     *                         "id": 1,
     *                         "nome": "Dra. Ana Martins",
     *                         "crm": "CRM001",
     *                         "created_at": "2026-07-22T23:07:46.000000Z",
     *                         "updated_at": "2026-07-22T23:07:46.000000Z"
     *                     },
     *
     *                     "tipo_consulta": {
     *                         "id": 1,
     *                         "nome": "Consulta Cardiológica",
     *                         "duracao": 30,
     *                         "hora_inicio": "08:00:00",
     *                         "hora_fim": "18:00:00",
     *                         "created_at": "2026-07-22T23:07:45.000000Z",
     *                         "updated_at": "2026-07-22T23:07:45.000000Z"
     *                     }
     *                 }
     *             }
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Consulta não encontrada"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $consulta = $this->consultaService->buscarConsultaPorId($id);

        if (!$consulta) {
            return response()->json([
                'success' => false,
                'message' => 'Consulta não encontrada.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $consulta
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/consultas",
     *     tags={"Consultas"},
     *     summary="Cadastra uma nova consulta",
     *     description="Cria uma nova consulta informando paciente, médico, tipo, data, horário e valor.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "paciente_id",
     *                 "medico_id",
     *                 "tipo_consulta_id",
     *                 "data_atendimento",
     *                 "hora_atendimento",
     *                 "valor_consulta"
     *             },
     *
     *             @OA\Property(
     *                 property="paciente_id",
     *                 type="integer",
     *                 example=20
     *             ),
     *
     *             @OA\Property(
     *                 property="medico_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *
     *             @OA\Property(
     *                 property="tipo_consulta_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *
     *             @OA\Property(
     *                 property="data_atendimento",
     *                 type="string",
     *                 format="date",
     *                 example="2026-06-20"
     *             ),
     *
     *             @OA\Property(
     *                 property="hora_atendimento",
     *                 type="string",
     *                 format="time",
     *                 example="13:00"
     *             ),
     *
     *             @OA\Property(
     *                 property="valor_consulta",
     *                 type="number",
     *                 format="float",
     *                 example=180.00
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Consulta criada com sucesso"
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {

            $consulta = $this->consultaService->criarConsulta($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Consulta cadastrada com sucesso.',
                'data' => $consulta
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
     *     path="/api/consultas/{id}",
     *     tags={"Consultas"},
     *     summary="Atualiza uma consulta",
     *     description="Atualiza uma consulta existente informando paciente, médico, tipo, data, horário e valor.",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da consulta",
     *         @OA\Schema(type="integer", example=20)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "paciente_id",
     *                 "medico_id",
     *                 "tipo_consulta_id",
     *                 "data_atendimento",
     *                 "hora_atendimento",
     *                 "valor_consulta"
     *             },
     *
     *             @OA\Property(
     *                 property="paciente_id",
     *                 type="integer",
     *                 example=20
     *             ),
     *
     *             @OA\Property(
     *                 property="medico_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *
     *             @OA\Property(
     *                 property="tipo_consulta_id",
     *                 type="integer",
     *                 example=2
     *             ),
     *
     *             @OA\Property(
     *                 property="data_atendimento",
     *                 type="string",
     *                 format="date",
     *                 example="2026-06-25"
     *             ),
     *
     *             @OA\Property(
     *                 property="hora_atendimento",
     *                 type="string",
     *                 format="time",
     *                 example="15:30"
     *             ),
     *
     *             @OA\Property(
     *                 property="valor_consulta",
     *                 type="number",
     *                 format="float",
     *                 example=250.00
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Consulta atualizada com sucesso"
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Consulta não encontrada"
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {

            $consulta = $this->consultaService->buscarConsultaPorId($id);

            if (!$consulta) {
                return response()->json([
                    'success'=>false,
                    'message'=>'Consulta não encontrada.'
                ],404);
            }

            $this->consultaService->atualizarConsulta($id,$request->all());

            return response()->json([
                'success'=>true,
                'message'=>'Consulta atualizada com sucesso.',
                'data'=>$this->consultaService->buscarConsultaPorId($id)
            ],200);

        } catch (ValidationException $e) {

            return response()->json([
                'success'=>false,
                'message'=>'Erro de validação.',
                'errors'=>$e->errors()
            ],422);

        } catch(\Exception $e){

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }


    /**
     * @OA\Delete(
     *     path="/api/consultas/{id}",
     *     tags={"Consultas"},
     *     summary="Remove uma consulta",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Consulta removida"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Consulta não encontrada"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->consultaService->deletarConsulta($id);

        if (!$deleted) {
            return response()->json([
                'success'=>false,
                'message'=>'Consulta não encontrada.'
            ],404);
        }

        return response()->json([
            'success'=>true,
            'message'=>'Consulta removida com sucesso.'
        ],200);
    }


    /**
     * @OA\Get(
     *     path="/api/consultas/medicos-por-tipo/{id}",
     *     tags={"Consultas"},
     *     summary="Lista médicos por tipo de consulta",
     *     description="Retorna os médicos disponíveis para um determinado tipo de consulta.",
     *
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
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de médicos"
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de consulta não encontrado"
     *     )
     * )
     */
    public function medicosPorTipo(int $id): JsonResponse
    {
        $medicos = $this->consultaService->buscarMedico($id);

        return response()->json([
            'success'=>true,
            'data'=>$medicos
        ],200);
    }
}