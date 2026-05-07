<?php

namespace App\Http\Controllers\Api\Bill;

use App\Http\Controllers\Controller;
use App\models\ServiceBooking;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    public function list(Request $request)
    {
        $query = ServiceBooking::query()
            ->with(['service' => function ($q) {
                $q->select('id', 'name', 'slug', 'cate_slug', 'image', 'price', 'status');
            }])
            ->orderBy('id', 'DESC');

        if ($request->filled('keyword')) {
            $keyword = trim((string) $request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('note', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('service', function ($sq) use ($keyword) {
                        $sq->where('name', 'LIKE', "%{$keyword}%")
                            ->orWhere('slug', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        $perPage = (int) ($request->get('per_page', 20));
        $data = $query->paginate($perPage);

        $data->getCollection()->transform(function (ServiceBooking $row) {
            $svc = $row->service;
            $row->service_name = $svc ? languageName($svc->name) : ('Dịch vụ #' . $row->service_id);
            $row->service_public_url = ($svc && $svc->cate_slug && $svc->slug)
                ? url('service/' . $svc->cate_slug . '/' . $svc->slug . '.html')
                : null;

            return $row;
        });

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function detail($id)
    {
        $booking = ServiceBooking::with(['service' => function ($q) {
            $q->select('id', 'name', 'slug', 'cate_slug', 'image', 'price', 'status', 'description');
        }])->findOrFail($id);

        $service = $booking->service;
        $serviceName = $service ? languageName($service->name) : ('Dịch vụ #' . $booking->service_id);
        $servicePublicUrl = ($service && $service->cate_slug && $service->slug)
            ? url('service/' . $service->cate_slug . '/' . $service->slug . '.html')
            : null;

        return response()->json([
            'data' => [
                'booking' => $booking,
                'service' => $service,
                'service_name' => $serviceName,
                'service_public_url' => $servicePublicUrl,
            ],
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $booking = ServiceBooking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'data' => true,
            'message' => 'success',
        ]);
    }
}
