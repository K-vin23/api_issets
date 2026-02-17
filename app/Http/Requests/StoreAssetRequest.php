<?php 
namespace App\Http\Requests; 
use Illuminate\Foundation\Http\FormRequest; 
class StoreAssetRequest extends FormRequest 
{ 
    
    public function authorize(): bool 
    {
        return true; 
    } 

    public function rules(): array 
    { 
        return [ 
            'assetId'       => 'nullable|integer',
            'serialNumber'  => 'required|string|max:200',
            'companyId'     => 'required|integer|exists:companies,companyId', 
            'assetType'     => 'required|string|max:4|exists:asset_types,typeId',
            'invoice'       => 'nullable|string|max:50', 
            'purchaseDate'  => 'nullable|date', 
            'registeredBy'  => 'nullable|integer|exists:users,userId' ,
            'internalId'    => 'nullable|string|max:100',
            'areaId'        => 'nullable|integer|exists:areas,areaId',
            'modelId'       => 'nullable|integer|exists:computer_models,modelId'
        ]; 
    } 
    
    public function messages() 
    { 
        return [
            'serialNumber.required' => 'El numero serial es obligatorio.',
            'serialNumber.max' => 'El numero serial no puede superar los 200 caracteres.',
            'companyId.required' => 'El activo debe pertenecer a una empresa.', 
            'companyId.exists' => 'La empresa no existe.',
            'assetType.required' => 'el tipo de activo es obligatorio',
            'assetType.exists' => 'El tipo de activo no existe.',
            'invoice.max' => 'La factura no puede superar los 50 caracteres.',
            'purchaseDate.date' => 'La fecha de compra debe ser una fecha válida.',
            'registeredBy.required' => 'el usuario que registra es obligatorio',  
            'registeredBy.exists' => 'El usuario que registra no existe'
        ]; 
    } 
}