<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Models\Upload;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

       
        $parsedcat = [
              [
              "id" => 10, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "Paket BOS", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/adaNJxbNHquGwHppj9E8fJv3iZHsNjdCXHQyEGqS.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/fH5wtTjHjqFOmm2xQCmKLxujJ16HrWgWZOxhLIQz.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "Paket-BOS-RyM4p", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 101, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "KABEL", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/8RHFbzZh2r6df7nHL6a1wBIEX2oAcoycETzvGRUY.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/8RHFbzZh2r6df7nHL6a1wBIEX2oAcoycETzvGRUY.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "CABBLING-KglSk", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 102, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "PANEL & KOMBINER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "https://hub.sonus.id/uploads/all/84jxNXUoVvqjm3abEF0tIp4gIKzu5OP6LsQ8VQdQ.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PANEL--KOMBINER-2DaML", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 103, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "PJUTS", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/OdYqPzRnRhTJnzTWwF7y1Ru2xOn1z7lG904DDj0a.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/OdYqPzRnRhTJnzTWwF7y1Ru2xOn1z7lG904DDj0a.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PJUTS-7Js6k", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 104, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "PANEL SURYA", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/SRhBDPgcfuH8gqu2or2w2D4xA6a6GrrpkUvAH8nw.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/SRhBDPgcfuH8gqu2or2w2D4xA6a6GrrpkUvAH8nw.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PV-MODULE-OV5e2", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 105, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "INVERTER", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/41ffFqbkRJ7XYmfTwIjGbtNpLnJSW3nEpkmc0lmz.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/41ffFqbkRJ7XYmfTwIjGbtNpLnJSW3nEpkmc0lmz.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "INVERTER-kb7Cc", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 106, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "MOUNTING", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/otFVTNMsmth71xYpQ88Z8RiM1FEuvn4AsVBw8chH.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/otFVTNMsmth71xYpQ88Z8RiM1FEuvn4AsVBw8chH.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "MOUNTING-indYx", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 107, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "BATERAI", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/ZcxPFlMkx1GGyZFFaOl5EVdWtNIUHfxE3xCwwghX.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/ZcxPFlMkx1GGyZFFaOl5EVdWtNIUHfxE3xCwwghX.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "BATTERY-dBG9u", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 108, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "BOS", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/VoBuuPrJ0rGRcBkVNLFsPYMq8iga2xNtN4x02MS9.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/VoBuuPrJ0rGRcBkVNLFsPYMq8iga2xNtN4x02MS9.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "BOS-TgPxR", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 109, 
              "parent_id" => 0, 
              "level" => 0, 
              "name" => "BIOMASA", 
              "order_level" => 0, 
              "banner" => "https://hub.sonus.id/uploads/all/nUmeLcbykDqlzlg5rM3hSKsXawgLv3bGjUfrGErH.jpg", 
              "icon" => "https://hub.sonus.id/uploads/all/nUmeLcbykDqlzlg5rM3hSKsXawgLv3bGjUfrGErH.jpg", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "BIOMASA-qCSYp", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "18/12/2024 00:27", 
              "updated_at" => "18/12/2024 00:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 104, 
              "parent_id" => 10, 
              "level" => 1, 
              "name" => "Paket BOS", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "Paket-BOS-AWNRn", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "30/07/2024 15:40", 
              "updated_at" => "30/07/2024 15:40", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 59, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "PV CABLE", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PV-CABLE-p5PJB", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:56", 
              "updated_at" => "12/01/2024 12:56", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 61, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "POWER CABLE", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "POWER-CABLE-iwDfK", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 84, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "CABLE ROUTING", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "CABLE-ROUTING-96RNs", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "22/01/2024 11:42", 
              "updated_at" => "22/01/2024 11:42", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 89, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "LADDER TRAY", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "LADDER-TRAY-yBhaf", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 12:58", 
              "updated_at" => "14/05/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 90, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "CABLE TRAY", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "CABLE-TRAY-edPdS", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 12:58", 
              "updated_at" => "14/05/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 91, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "COVER TRAY AND LADDER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "COVER-TRAY-AND-LADDER-KMTuD", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 12:58", 
              "updated_at" => "14/05/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 111, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "ACCESORIES", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ACCESORIES-YoV8d", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "30/05/2024 13:27", 
              "updated_at" => "30/05/2024 13:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 112, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "CABLE TRAY", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "CABLE-TRAY-uAAdf", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "30/05/2024 13:27", 
              "updated_at" => "30/05/2024 13:27", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 113, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "COVER TRAY AND LADDER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "COVER-TRAY-AND-LADDER-gzXHN", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "30/05/2024 13:28", 
              "updated_at" => "30/05/2024 13:28", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 114, 
              "parent_id" => 101, 
              "level" => 1, 
              "name" => "LADDER TRAY", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "LADDER-TRAY-zESAz", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "30/05/2024 13:28", 
              "updated_at" => "30/05/2024 13:28", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 86, 
              "parent_id" => 102, 
              "level" => 1, 
              "name" => "PANEL KOMBINER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PANEL-KOMBINER-9P9Vd", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/03/2024 15:23", 
              "updated_at" => "14/03/2024 15:52", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 115, 
              "parent_id" => 103, 
              "level" => 1, 
              "name" => "TIANG PJUTS", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "TIANG-PJUTS-9BYTV", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "02/09/2024 14:12", 
              "updated_at" => "02/09/2024 14:12", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 60, 
              "parent_id" => 104, 
              "level" => 1, 
              "name" => "NON TKDN", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "NON-TKDN-np6iy", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:56", 
              "updated_at" => "12/01/2024 12:56", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 88, 
              "parent_id" => 104, 
              "level" => 1, 
              "name" => "TKDN", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "TKDN-6dsX5", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "21/03/2024 09:37", 
              "updated_at" => "21/03/2024 09:37", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 62, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "HYBRID", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "HYBRID-P0UN3", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 63, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "ON GRID", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ON-GRID-SYIhR", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 64, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "CT", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "CT-Ml7ER", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 65, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "OFF GRID / HYBRID", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "OFF-GRID--HYBRID-4K9vF", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 72, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "ENERGY METER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ENERGY-METER-oGa9v", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 73, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "POWER SENSOR", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "POWER-SENSOR-ZV7Tu", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 74, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "SMARTDONGLE", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "SMARTDONGLE-Cr3FE", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 75, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "SMARTLOGGER", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "SMARTLOGGER-JO5vI", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 76, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "SINGLE PHASE", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "SINGLE-PHASE-nujRG", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 77, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "THREE PHASE", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "THREE-PHASE-Qik5W", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 78, 
              "parent_id" => 105, 
              "level" => 1, 
              "name" => "SEC / HYBRID", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "SEC-BqGI4", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:59", 
              "updated_at" => "12/01/2024 12:59", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 66, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "TILEHOOK", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "TILEHOOK-cOCCI", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 67, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "BALLAST", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "BALLAST-etolT", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 68, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "ACCESORIES", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ACCESORIES-LYRDx", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:57", 
              "updated_at" => "12/01/2024 12:57", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 69, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "KLIPLOK", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "KLIPLOK-6ts0l", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 70, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "L-FEET", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "L-FEET-fFYjT", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 71, 
              "parent_id" => 106, 
              "level" => 1, 
              "name" => "TILE HOOK", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "TILE-HOOK-fX4Mh", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:58", 
              "updated_at" => "12/01/2024 12:58", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 57, 
              "parent_id" => 107, 
              "level" => 1, 
              "name" => "PLTS", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "PLTS-aLfqH", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:56", 
              "updated_at" => "12/01/2024 12:56", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 58, 
              "parent_id" => 107, 
              "level" => 1, 
              "name" => "OTOMOTIF", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "OTOMOTIF-ehdxO", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:56", 
              "updated_at" => "12/01/2024 12:56", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 79, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "ELECTRICITY SUPPORT", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ELECTRICITY-SUPPORT-PaJtV", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "12/01/2024 12:59", 
              "updated_at" => "12/01/2024 12:59", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 93, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "UPS", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "UPS-qWZfO", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:20", 
              "updated_at" => "14/05/2024 13:20", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 94, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "RELAY PROTEKSI DIGITAL", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "RELAY-PROTEKSI-DIGITAL-1WoOP", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:20", 
              "updated_at" => "14/05/2024 13:20", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 95, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "MCCB", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "MCCB-qVHY0", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:20", 
              "updated_at" => "14/05/2024 13:20", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 96, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "KONTAKTOR", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "KONTAKTOR-ZM8KD", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:21", 
              "updated_at" => "14/05/2024 13:21", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 97, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "POWERTAG", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "POWERTAG-lbDTe", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:21", 
              "updated_at" => "14/05/2024 13:21", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 98, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "TERMINAL BLOK", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "TERMINAL-BLOK-G5iRq", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 13:21", 
              "updated_at" => "14/05/2024 13:21", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 99, 
              "parent_id" => 108, 
              "level" => 1, 
              "name" => "ACB", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "ACB-Sp71t", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "14/05/2024 15:36", 
              "updated_at" => "14/05/2024 15:36", 
              "deleted_at" => "" 
              ], 
              [
              "id" => 85, 
              "parent_id" => 109, 
              "level" => 1, 
              "name" => "BIOMASA", 
              "order_level" => 0, 
              "banner" => "", 
              "icon" => "", 
              "featured" => 0, 
              "digital" => 0, 
              "top" => 0, 
              "slug" => "BIOMASA-BHTu7", 
              "meta_title" => "", 
              "meta_description" => "", 
              "meta_image" => "", 
              "sales_amount" => 0, 
              "created_at" => "13/03/2024 12:46", 
              "updated_at" => "13/03/2024 12:46", 
              "deleted_at" => "" 
              ], 
              [
                "id" => 110, 
                "parent_id" => 59, 
                "level" => 3, 
                "name" => "Sub Kabel", 
                "order_level" => 0, 
                "banner" => "", 
                "icon" => "", 
                "featured" => 0, 
                "digital" => 0, 
                "top" => 0, 
                "slug" => "Sub-Kabel-byAdi", 
                "meta_title" => "kabel", 
                "meta_description" => "kabel", 
                "meta_image" => "", 
                "sales_amount" => 0, 
                "created_at" => "19/06/2024 18:39", 
                "updated_at" => "19/06/2024 18:39", 
                "deleted_at" => "" 
              ] 
        ]; 

        
 
        $client = new Client();

        foreach ($parsedcat as $cat) {
            try {
                \DB::beginTransaction();

                // Clean up existing data with the same ID
                Category::where('id', $cat['id'])->delete();
                CategoryTranslation::where('category_id', $cat['id'])->delete();

                $category = new Category;
                $category->id = $cat['id'];
                $category->parent_id = $cat['parent_id'];
                $category->level = $cat['level'];
                $category->name = $cat['name'];
                $category->order_level = $cat['order_level'];
                if (!empty($cat['banner'])) {
                    $response = $client->get($cat['banner'], ['timeout' => 10]);
                    $bannerContents = $response->getBody()->getContents();
                    $bannerName = pathinfo(basename($cat['banner']), PATHINFO_FILENAME) . '.webp';
                    try {
                      $manager = new ImageManager(new Driver());

                      // reading gif image
                      $image = $manager->read($bannerContents);

                      // encoding jpeg data
                      $encoded = $image->toWebp(80);
                      $image = $encoded;
                      $filePath = 'uploads/all/' . $bannerName;
                      $i = Storage::put('uploads/all/' . $bannerName, $image);
                    } catch (\Exception $e) {
                      $this->error('Failed to store banner: ' . $e->getMessage());
                      continue;
                    }
                  $upload = new Upload;
                  $upload->file_original_name = $cat['name'];
                  $upload->file_name = 'uploads/all/' . $bannerName; 
                  $upload->user_id = 1; // Assuming user_id is 1 for this example

                  $upload->extension = pathinfo($filePath, PATHINFO_EXTENSION);
                  $upload->type = 'image';
                  $upload->file_size = Storage::size('uploads/all/' . $bannerName);
                  $upload->save();
                  $category->banner = $upload->id;
                  // echo "  ban =".$category->banner; 
                }
                if (!empty($cat['icon'])) {
                  
                    $response = $client->get($cat['icon'], ['timeout' => 10]);
                    $iconContents = $response->getBody()->getContents();
                    // $iconName = pathinfo(basename($cat['icon']), PATHINFO_FILENAME) . '.webp';
                    $iconName = pathinfo(basename($cat['icon']), PATHINFO_FILENAME);
                    $iconName = preg_replace('/[^A-Za-z0-9-]+/', '-', $iconName);
                    $iconName = ltrim($iconName, '-');
                    $iconName .= '.webp';
                    try {
                      $manager = new ImageManager(new Driver());

                      // reading gif image
                      $image = $manager->read($bannerContents);

                      // encoding jpeg data
                      $encoded = $image->toWebp(80);
                      $image = $encoded;
                      Storage::put('uploads/all/' . $iconName, $image);
                    } catch (\Exception $e) {
                      $this->error('Failed to store icon: ' . $e->getMessage());
                      continue;
                    }
                  $upload = new Upload;
                  $upload->file_original_name = $cat['name'];
                  $upload->file_name = 'uploads/all/' . $iconName;
                  $upload->user_id = 1; // Assuming user_id is 1 for this example
                  $upload->extension = pathinfo($cat['icon'], PATHINFO_EXTENSION);
                  $upload->type = 'image';
                  $upload->file_size = strlen(file_get_contents($cat['icon']));
                  $upload->save();
                  $category->icon = $upload->id;
                  // echo "  icon =".$category->icon;

                }

              $category->featured = $cat['featured'];
              $category->digital = $cat['digital'];
              $category->top = $cat['top'];
              $category->slug = $cat['slug'];
              $category->meta_title = $cat['meta_title'];
              $category->meta_description = $cat['meta_description'];
              $category->meta_image = $cat['meta_image'];
              $category->sales_amount = $cat['sales_amount'];
              $category->created_at = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $cat['created_at']);
              $category->updated_at = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $cat['updated_at']);
              $category->deleted_at = $cat['deleted_at'] ? \Carbon\Carbon::createFromFormat('d/m/Y H:i', $cat['deleted_at']) : null;
              $category->save();

              $category_translation = CategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'category_id' => $category->id]);
              $category_translation->name = $cat['name'];
              $category_translation->save();

              \DB::commit();
              echo "\n\n  success = ".$category->name;

              #kill the process on 1st loop
              // exit;
            } 
            catch (\Exception $e) {
              \DB::rollBack();
              echo "\n\n  fail = ".$cat['name']." ".$e->getMessage();

              $this->error('Failed to import category: ' . $cat['name'] . '. Error: ' . $e->getMessage());
            }
        }
 
        
      
    }
}
