<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

 
    public function index(): AnonymousResourceCollection
    {
        return Cache::remember("employees",  function () {
            $listOfEmployees = $this->employeeRepository->findAll();
            return EmployeeResource::collection($listOfEmployees);
        });
    }


    public function store(EmployeeRequest $request): EmployeeResource
    {
        $employee = $this->employeeRepository->store((array)$request->validated());
        return new EmployeeResource($employee);
    }


    public function show(int $employeeId): EmployeeResource
    {
        return Cache::remember("employee.$employeeId",  function () use ($employeeId) {
            $employee = $this->employeeRepository->findOrFail($employeeId);
            return new EmployeeResource($employee);
        });
    }

    public function update(EmployeeRequest $request, int $employeeId): JsonResponse
    {
        $this->employeeRepository->update((array)$request->validated(), $employeeId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    public function destroy(int $employeeId): JsonResponse
    {
        $this->employeeRepository->delete($employeeId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
