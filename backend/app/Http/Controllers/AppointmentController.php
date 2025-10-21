<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\AppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()->with(['service', 'professional', 'author']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($request->user()?->role === Role::Professional) {
            $query->where('professional_id', $request->user()->id);
        }

        $appointments = $query->orderByDesc('scheduled_at')->paginate(15);

        return AppointmentResource::collection($appointments);
    }

    public function store(AppointmentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()?->id;

        $appointment = Appointment::create($data);

        return (new AppointmentResource($appointment->load(['service', 'professional', 'author'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Appointment $appointment): AppointmentResource
    {
        return new AppointmentResource($appointment->load(['service', 'professional', 'author']));
    }

    public function update(AppointmentRequest $request, Appointment $appointment): AppointmentResource
    {
        $data = $request->validated();

        if ($request->user()?->role === Role::Professional && $appointment->professional_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN, 'Profissionais só podem alterar seus próprios agendamentos.');
        }

        $appointment->update($data);

        return new AppointmentResource($appointment->load(['service', 'professional', 'author']));
    }

    public function destroy(Request $request, Appointment $appointment)
    {
        if ($request->user()?->role === Role::Professional && $appointment->professional_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN, 'Profissionais só podem excluir seus próprios agendamentos.');
        }

        $appointment->delete();

        return response()->noContent();
    }
}
