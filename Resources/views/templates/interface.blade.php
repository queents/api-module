@php echo "<?php";
@endphp

namespace Modules\{{ $module }}\Interfaces;

interface {{ $model }}RepositoryInterface
{

    public function getAllData($paginate,$searchItems,$ordering_filed,$ordering_dir);
    public function getItemById($itemId);
    public function deleteItem($itemId);
    public function createItem( array $newDetails);
    public function updateItem($itemId, array $newDetails);
}
