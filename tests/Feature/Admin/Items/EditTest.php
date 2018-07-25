<?php
declare(strict_types = 1);

namespace Tests\Feature\Admin\Items;

use App\Entity\Item;
use App\Repository\Item\ItemRepository;
use App\Services\Item\Image\Hashing\Hasher;
use App\Services\Item\Image\Image;
use App\Services\Item\Type;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EditTest extends TestCase
{
    public function testCurrentImage(): void
    {
        $this->transaction();
        $this->authAdmin();
        $image = $this->image();
        $item = $this->createItem($image);

        $name = 'New coal ore';
        $description = 'New coal ore description';
        $itemType = Type::ITEM;
        $gameId = '16';

        $response = $this->post(route('admin.items.edit', ['item' => $item->getId()]), [
            'name' => $name,
            'description' => $description,
            'item_type' => $itemType,
            'image_type' => 'current',
            'signature' => $gameId,
            'enchantments' => json_encode([])
        ]);

        $response->assertStatus(200);
        $repository = $this->app->make(ItemRepository::class);
        /** @var Item $item */
        $item = $repository->find($item->getId());
        self::assertNotNull($item);
        self::assertEquals($name, $item->getName());
        self::assertEquals($description, $item->getDescription());
        self::assertEquals($itemType, $item->getType());
        self::assertEquals($image, $item->getImage());
        self::assertEquals($gameId, $item->getSignature());
        self::assertNull($item->getExtra());

        $this->deleteFile();

        $this->rollback();
    }

    public function testDefaultImage(): void
    {
        $this->transaction();
        $this->authAdmin();
        $image = $this->image();
        $item = $this->createItem($image);

        $name = 'New coal ore';
        $description = 'New coal ore description';
        $itemType = Type::ITEM;
        $gameId = '16';

        $response = $this->post(route('admin.items.edit', ['item' => $item->getId()]), [
            'name' => $name,
            'description' => $description,
            'item_type' => $itemType,
            'image_type' => 'default',
            'signature' => $gameId,
            'enchantments' => json_encode([])
        ]);

        $response->assertStatus(200);
        $repository = $this->app->make(ItemRepository::class);
        /** @var Item $item */
        $item = $repository->find($item->getId());
        self::assertNotNull($item);
        self::assertEquals($name, $item->getName());
        self::assertEquals($description, $item->getDescription());
        self::assertEquals($itemType, $item->getType());
        self::assertNull($item->getImage());
        self::assertEquals($gameId, $item->getSignature());
        self::assertNull($item->getExtra());

        $this->deleteFile();

        $this->rollback();
    }

    public function testUploadedImage(): void
    {
        $this->transaction();
        $this->authAdmin();

        $path = 'tests/Feature/Admin/Items';
        $originalPath = $this->app->basePath("{$path}/coal_ore_original.png");
        $uploadablePath = $this->app->basePath("{$path}/coal_ore.png");
        // Copy the file as it will removed when it is uploaded.
        $this->app->make(Filesystem::class)->copy($originalPath, $uploadablePath);
        $file = new UploadedFile($uploadablePath, 'coal_ore.png', 'image/png', null, null, true);

        $name = 'New coal ore';
        $description = 'New coal ore description';
        $itemType = Type::ITEM;
        $gameId = '16';

        $item = $this->createItem();

        $response = $this->post(route('admin.items.edit', ['item' => $item->getId()]), [
            'name' => $name,
            'description' => $description,
            'item_type' => $itemType,
            'image_type' => 'upload',
            'file' => $file,
            'signature' => $gameId,
            'enchantments' => json_encode([])
        ]);

        $response->assertStatus(200);

        $hasher = $this->app->make(Hasher::class);
        $filename = "{$hasher->make($originalPath)}.{$file->getClientOriginalExtension()}";
        self::assertFileExists(Image::absolutePath($filename));

        $repository = $this->app->make(ItemRepository::class);
        /** @var Item $item */
        $item = $repository->find($item->getId());
        self::assertNotNull($item);
        self::assertEquals($name, $item->getName());
        self::assertEquals($description, $item->getDescription());
        self::assertEquals($itemType, $item->getType());
        self::assertEquals($filename, $item->getImage());
        self::assertEquals($gameId, $item->getSignature());
        self::assertNull($item->getExtra());

        // Delete uploaded image.
        $this->app->make(Filesystem::class)->delete(Image::absolutePath($filename));

        $this->rollback();
    }

    public function testBrowseImage(): void
    {
        $this->transaction();
        $this->authAdmin();
        $item = $this->createItem();

        $name = 'New coal ore';
        $description = 'New coal ore description';
        $itemType = Type::ITEM;
        $gameId = '16';

        $image = $this->image();

        $response = $this->post(route('admin.items.edit', ['item' => $item->getId()]), [
            'name' => $name,
            'description' => $description,
            'item_type' => $itemType,
            'image_type' => 'browse',
            'image_name' => $image,
            'signature' => $gameId,
            'enchantments' => json_encode([])
        ]);

        $response->assertStatus(200);
        $repository = $this->app->make(ItemRepository::class);
        /** @var Item $item */
        $item = $repository->find($item->getId());
        self::assertNotNull($item);
        self::assertEquals($name, $item->getName());
        self::assertEquals($description, $item->getDescription());
        self::assertEquals($itemType, $item->getType());
        self::assertEquals($image, $item->getImage());
        self::assertEquals($gameId, $item->getSignature());
        self::assertNull($item->getExtra());

        $this->deleteFile();

        $this->rollback();
    }

    private function image(): string
    {
        $this->app->make(Filesystem::class)->copy(
            $this->app->basePath("tests/Feature/Admin/Items/coal_ore_original.png"),
            $this->filePath()
        );

        return $this->filename();
    }

    private function deleteFile(): void
    {
        $this->app->make(Filesystem::class)->delete($this->filePath());
    }

    private function createItem(?string $image = null): Item
    {
        $item = new Item('Coal ore', Type::ITEM, '16');
        if ($image !== null) {
            $item->setImage($image);
        }
        $this->app->make(ItemRepository::class)->create($item);

        return $item;
    }

    private function filename(): string
    {
        return 'coal_ore.png';
    }

    private function filePath(): string
    {
        return public_path("img/shop/items/{$this->filename()}");
    }
}
