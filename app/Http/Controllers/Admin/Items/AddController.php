<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\Admin\Items\Add\Add;
use App\DataTransferObjects\Admin\Items\Add\EnchantmentFromFrontend;
use App\Handlers\Admin\Items\Add\AddHandler;
use App\Handlers\Admin\Items\Add\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Items\AddRequest;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use function App\permission_middleware;

class AddController extends Controller
{
    public function __construct()
    {
        //$this->middleware(permission_middleware(Permissions::ADMIN_ITEMS_CRUD_ACCESS));
    }

    public function render(RenderHandler $handler)
    {
        $dto = $handler->handle();

        return new JsonResponse(Status::SUCCESS, [
            'images' => $dto->getImages(),
            'enchantments' => $dto->getEnchantments()
        ]);
    }

    public function add(AddRequest $request, AddHandler $handler, Notificator $notificator): JsonResponse
    {
        $enchantments = [];
        foreach (json_decode($request->get('enchantments'), true) as $item) {
            $enchantments[] = new EnchantmentFromFrontend($item['id'], $item['level']);
        }

        $dto = (new Add())
            ->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setItemType($request->get('item_type'))
            ->setImageType($request->get('image_type'))
            ->setFile($request->file('file'))
            ->setImageName($request->get('image_name'))
            ->setGameId($request->get('game_id'))
            ->setEnchantments($enchantments)
            ->setExtra($request->get('extra'));

        $handler->handle($dto);
        $notificator->notify(new Success(__('msg.admin.items.add.success')));

        return new JsonResponse(Status::SUCCESS);
    }
}
