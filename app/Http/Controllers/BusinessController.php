<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($parameters)
    {
        $query = $parameters;
        parse_str($query, $qureyArray);

        $offset = $qureyArray['offset'] ?? 0;
        $limit = $qureyArray['limit'] ?? 20;

        $business = DB::table('businesses');

        if (array_key_exists('term', $qureyArray)) {
            $business->where('alias', $qureyArray['term']);
        }

        if (array_key_exists('price', $qureyArray)) {
            $business->where('price', $qureyArray['price']);
        }

        if (array_key_exists('latitude', $qureyArray)) {
            $business->where('coordinates', 'like', '%'.$qureyArray['latitude'].'%');
        }

        $business->skip($offset);
        $business->take($limit);
        $businesses = $business->get();

        return $this->sendResponse([
            'businesses' => $businesses
        ], '');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parameters = $request->request;
        $parameters->add([
            'uuid' => $parameters->all()['id']
        ]);
        try {
            Business::create($parameters->all());
        } catch (\Throwable $th) {
            $this->sendError('Failed to save the business', ['error' => $th->getMessage()]);
        }

        return $this->sendResponse([], 'Stored successful');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $parameters = $request->request;
        $data = $parameters->all();
        $uuid = $data['id'];
        unset($data['id']);
        try {
            Business::where(['uuid' => $uuid])
                        ->update($data);
        } catch (\Throwable $th) {
            $this->sendError('Failed to delete the business', ['error' => $th->getMessage()]);
        }
        return $this->sendResponse([], 'Updated successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Business::where('uuid', $id)->delete();
        } catch (\Throwable $th) {
            $this->sendError('Failed to delete the business', ['error' => $th->getMessage()]);
        }

        return $this->sendResponse([], 'Deleted successful');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
