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
            'companyId'     => 'required|integer|exists:companies,companyId',
            'areaId'        => 'nullable|integer|exists:areas,areaId',
            'typeId'        => 'required|string|min:1|max:4|exists:asset_types,typeId',
            'modelId'       => 'nullable|integer|exists:computer_models,modelId',
            'serialNumber'  => 'required|string|max:200',
            'internalId'    => 'required|string|max:100',
            'invoice'       => 'nullable|string|max:50',
            'purchaseDate'  => 'nullable|date',
            'networkName'   => 'nullable|string|max:50',
            'assignedUser'  => 'nullable|integer|exists:users,userId',
            'details'       => 'nullable|string|min:1|max:100',
            'lastUpdate'    => 'nullable|date',
            'isActive'      => 'nullable|boolean',
            'registeredBy'  => 'nullable|integer|exists:users,userId' ,
            'memories'      => 'nullable|array|max:3',
            'memories.*.id' => 'sometimes|required|exists:memories,memoryId',
            'disks'         => 'nullable|array|max:3',
            'disks.*.id'    => 'sometimes|required|exists:hard_disks,diskId',
            'licenses'      => 'nullable|array',
            'licenses.*.licenseId'  => 'sometimes|required|exists:licenses,licenseId',
            'licenses.*.licenseKey' => 'sometimes|required|string'
        ]; 
    } 
    
    public function messages() 
    { 
        return [
            'companyId.required'    => 'El activo debe pertenecer a una empresa.',
            'areaId.required'       => 'El activo debe ser asignado a una area.',
            'modelId.required'      => 'Se debe especificar el modelo del activo.',
            'typeId.required'       => 'el tipo de activo es obligatorio',
            'serialNumber.required' => 'El numero serial es obligatorio.',
            'internalId.required'   => 'El id del activo en la empresa es obligatorio.',
            'serialNumber.max'      => 'El numero serial no puede superar los 200 caracteres.',
            'companyId.exists'      => 'La empresa no se encuentra registrada.',
            'areaId.exists'         => 'El area no se encuentra registrada.',
            'typeId.exists'         => 'No se encuentra el tipo de activo.',
            'modelId.exists'        => 'No se encuentra el modelo del activo.',
            'assignedUser.exists'   => 'No se encuentra el usuario asignado al activo.',
            'registeredBy.exists'   => 'No se encuentra el usuario que registra el activo.',
            'memories.*.id.exists'  => 'No se encuentra la memoria en el catalogo.', 
            'disks.*.id.exists'     => 'No se encuentra el disco en el catalogo.',
            'licenses.*.licenseId'  => 'No se encuentra la licencia en el catalogo.',
            'purchaseDate.date'     => 'La fecha de compra debe ser una fecha válida.',
            'lastUpdate.date'       => 'La fecha de actualización debe ser una fecha válida.'
        ]; 
    } 
}