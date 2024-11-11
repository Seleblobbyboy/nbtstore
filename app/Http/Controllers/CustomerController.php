<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Invoices;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function storeCustomerInfo(Request $request)
    {
        // หาข้อมูลลูกค้าจาก session
        $userId = Session::get('Users');
        $customer = Customers::where('CustomerID', $userId)->first();
        // ตรวจสอบว่าพบลูกค้าหรือไม่
        // ตรวจสอบว่าพบลูกค้าหรือไม่
        if ($customer) {
            // บันทึกข้อมูลที่อยู่ในตาราง customer_addresses
            $customerAddress = CustomerAddress::create([
                'CustomerID' => $customer->CustomerID,
                'CustomerName' => $request->input('full_name'),
                'Address' => $request->input('Description'),
                'PhoneNumber' => $request->input('phone'),
                'PostalCode' => $request->input('postal_code'),
                'Province' => $request->input('province'),
                'District' => $request->input('district'),
                'Subdistrict' => $request->input('sub_district'),
            ]);

            // เช็คว่าผู้ใช้ต้องการใบกำกับภาษีหรือไม่
            if ($request->input('need_invoice')) { // เช็คว่าค่าของ need_invoice เป็น true หรือไม่
                // ตรวจสอบว่ามีการส่งข้อมูลที่จำเป็นมาครบถ้วนหรือไม่
                $invoiceData = [
                    'CustomerID' => $customer->CustomerID,
                    'AddressID' => $customerAddress->AddressID, // เพิ่ม AddressID จาก customerAddress ที่เพิ่งสร้าง
                    'FullName' => $request->input('invoice_full_name'),
                    'IDCardNumber' => $request->input('id_card'),
                    'PhoneNumber' => $request->input('invoice_phone'),
                    'Address' => $request->input('invoice_address'),
                    'PostalCode' => $request->input('invoice_postal_code'),
                    'Province' => $request->input('invoice_province'),
                    'District' => $request->input('invoice_district'),
                    'Subdistrict' => $request->input('invoice_sub_district'),
                ];

                // ตรวจสอบว่า FullName มีค่าหรือไม่
                if (!empty($invoiceData['FullName'])) {
                    // บันทึกข้อมูลใบกำกับภาษีในตาราง invoices
                    Invoices::create($invoiceData);
                } else {
                    return redirect()->back()->with('error', 'กรุณากรอกข้อมูลสำหรับใบกำกับภาษีให้ครบถ้วน');
                }
            }

            return redirect()->back()->with('success', 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลลูกค้า');
        }
    }



    public function destroy($id)
    {
        // ลบข้อมูลลูกค้าจากตาราง customers
        $useID = Session::get('Users');
        $address = Session::get('address');
        $CustomerAddress = CustomerAddress::find($id);

        if ($CustomerAddress) {
            $CustomerAddress->forceDelete();
        }

        $Invoices = Invoices::where('CustomerID', $useID)->first();

        if ($Invoices) {
            $Invoices->forceDelete();
        }
        if ($address == $id) {
            Session::forget('address');
        }
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

    function SelectAddress($id)
    {
        $useID = Session::put('address', $id);
        return redirect('/cart/shopping')->with('success', 'เลือกที่อยู่เรียบร้อยแล้ว');
    }
}
