<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Customer API",
 *     version="1.0.0",
 *     description="API Documentation for Customer operations"
 * )
 */

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     required={"name", "id_number", "dob", "email"},
 *     @OA\Property(property="id", type="integer", readOnly=true),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="id_number", type="string"),
 *     @OA\Property(property="dob", type="string", format="date"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/customers",
     *     summary="Get list of customers",
     *     @OA\Response(
     *         response=200,
     *         description="A list of customers",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Customer"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $customers = Customer::paginate(10);
        return response()->json([
            'data' => $customers
        ]);
    }

    /**
     * @OA\Post(
     *     path="/customers",
     *     summary="Create a new customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'id_number' => $request->id_number,
            'dob' => $request->dob,
            'email' => $request->email
        ]);
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * @OA\Get(
     *     path="/customers/{customer}",
     *     summary="Get a specific customer",
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer data",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * @OA\Put(
     *     path="/customers/{customer}",
     *     summary="Update a customer",
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated customer",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     )
     * )
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->name = $request->name;
        $customer->id_number = $request->id_number;
        $customer->dob = $request->dob;
        $customer->email = $request->email;
        $customer->save();

        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/customers/{customer}",
     *     summary="Delete a customer",
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Customer deleted"
     *     )
     * )
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([
            'message' => 'customer deleted'
        ], 204);
    }
}
