<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PacienteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PacienteApiController extends Controller
{
    protected PacienteService $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }


   /**
     * @OA\Get(
     *     path="/api/pacientes",
     *     tags={"Pacientes"},
     *     summary="Lista todos os pacientes",
     *     description="Retorna todos os pacientes cadastrados.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pacientes retornada com sucesso.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="nome",
     *                         type="string",
     *                         example="João da Silva"
     *                     ),
     *                     @OA\Property(
     *                         property="cpf",
     *                         type="string",
     *                         example="11122233344"
     *                     ),
     *                     @OA\Property(
     *                         property="data_nascimento",
     *                         type="string",
     *                         format="date",
     *                         example="1980-03-15"
     *                     ),
     *                     @OA\Property(
     *                         property="telefone",
     *                         type="string",
     *                         example="48999999999"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2026-07-22T23:07:46.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2026-07-22T23:07:46.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $pacientes = $this->pacienteService->listarPacientes();

        return response()->json([
            'success' => true,
            'data' => $pacientes
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/pacientes/{id}",
     *     tags={"Pacientes"},
     *     summary="Busca um paciente pelo ID",
     *     description="Retorna um paciente específico pelo identificador.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do paciente",
     *         @OA\Schema(
     *             type="integer",
     *             example=23
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente encontrado.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=23
     *                 ),
     *                 @OA\Property(
     *                     property="nome",
     *                     type="string",
     *                     example="Maria Souza"
     *                 ),
     *                 @OA\Property(
     *                     property="cpf",
     *                     type="string",
     *                     example="12345678900"
     *                 ),
     *                 @OA\Property(
     *                     property="data_nascimento",
     *                     type="string",
     *                     format="date",
     *                     example="1990-05-15"
     *                 ),
     *                 @OA\Property(
     *                     property="telefone",
     *                     type="string",
     *                     example="48999887766"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2026-07-23T23:12:51.000000Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2026-07-23T23:12:51.000000Z"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente não encontrado."
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $paciente = $this->pacienteService->buscarPacientePorId($id);

        if (!$paciente) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente não encontrado.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $paciente
        ], 200);
    }


    /**
     * @OA\Post(
     *     path="/api/pacientes",
     *     tags={"Pacientes"},
     *     summary="Cadastra um novo paciente",
     *     description="Cria um novo paciente no sistema.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome",
     *                 "cpf",
     *                 "data_nascimento",
     *                 "telefone"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Maria Souza"
     *             ),
     *             @OA\Property(
     *                 property="cpf",
     *                 type="string",
     *                 example="12345678900"
     *             ),
     *             @OA\Property(
     *                 property="data_nascimento",
     *                 type="string",
     *                 format="date",
     *                 example="1990-05-15"
     *             ),
     *             @OA\Property(
     *                 property="telefone",
     *                 type="string",
     *                 example="48999887766"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Paciente cadastrado com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Paciente cadastrado com sucesso.",
     *                 "data": {
     *                     "id": 21,
     *                     "nome": "Maria Souza",
     *                     "cpf": "12345678900",
     *                     "data_nascimento": "1990-05-15T00:00:00.000000Z",
     *                     "telefone": "48999887766",
     *                     "created_at": "2026-07-23T23:30:00.000000Z",
     *                     "updated_at": "2026-07-23T23:30:00.000000Z"
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

            $paciente = $this->pacienteService->cadastrarPaciente(
                $request->all()
            );

            return response()->json([
                'success' => true,
                'message' => 'Paciente cadastrado com sucesso.',
                'data' => $paciente
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
     *     path="/api/pacientes/{id}",
     *     tags={"Pacientes"},
     *     summary="Atualiza um paciente",
     *     description="Atualiza os dados de um paciente existente.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do paciente",
     *         @OA\Schema(
     *             type="integer",
     *             example=23
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={
     *                 "nome",
     *                 "cpf",
     *                 "data_nascimento",
     *                 "telefone"
     *             },
     *             @OA\Property(
     *                 property="nome",
     *                 type="string",
     *                 example="Maria Souza"
     *             ),
     *             @OA\Property(
     *                 property="cpf",
     *                 type="string",
     *                 example="12345678900"
     *             ),
     *             @OA\Property(
     *                 property="data_nascimento",
     *                 type="string",
     *                 format="date",
     *                 example="1990-05-15"
     *             ),
     *             @OA\Property(
     *                 property="telefone",
     *                 type="string",
     *                 example="48999887767"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente atualizado com sucesso.",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Paciente atualizado com sucesso.",
     *                 "data": {
     *                     "id": 23,
     *                     "nome": "Maria Souza",
     *                     "cpf": "12345678900",
     *                     "data_nascimento": "1990-05-15T03:00:00.000000Z",
     *                     "telefone": "48999887767",
     *                     "created_at": "2026-07-23T23:12:51.000000Z",
     *                     "updated_at": "2026-07-23T23:15:55.000000Z"
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente não encontrado."
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

            $paciente = $this->pacienteService->buscarPacientePorId($id);

            if (!$paciente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paciente não encontrado.'
                ], 404);
            }

            $this->pacienteService->atualizarPaciente(
                $id,
                $request->all()
            );

            $pacienteAtualizado = $this->pacienteService->buscarPacientePorId($id);

            return response()->json([
                'success' => true,
                'message' => 'Paciente atualizado com sucesso.',
                'data' => $pacienteAtualizado
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
     *     path="/api/pacientes/{id}",
     *     tags={"Pacientes"},
     *     summary="Remove um paciente",
     *     description="Exclui um paciente pelo ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do paciente",
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paciente removido com sucesso."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Paciente não encontrado."
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->pacienteService->excluirPaciente($id);

        if (!$deleted) {

            return response()->json([
                'success' => false,
                'message' => 'Paciente não encontrado.'
            ], 404);

        }

        return response()->json([
            'success' => true,
            'message' => 'Paciente removido com sucesso.'
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/pacientes/search",
     *     tags={"Pacientes"},
     *     summary="Busca pacientes pelo nome",
     *     description="Pesquisa pacientes utilizando um termo.",
     *     @OA\Parameter(
     *         name="term",
     *         in="query",
     *         required=true,
     *         description="Nome ou termo de pesquisa",
     *         @OA\Schema(
     *             type="string",
     *             example="Maria"
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
        $term = $request->get('term');

        $pacientes = $this->pacienteService->buscar($term);

        return response()->json([
            'success' => true,
            'data' => $pacientes
        ], 200);
    }
}