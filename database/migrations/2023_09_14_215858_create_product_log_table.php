<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('action');
            $table->json('data');
            $table->timestamps();
        });

        // Criação da trigger após a inserção
        DB::unprepared('
            CREATE TRIGGER product_log_after_insert AFTER INSERT ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO product_log (product_id, action, data, created_at, updated_at)
                VALUES (NEW.id, \'Insert\', JSON_OBJECT(
                    "code", NEW.code,
                    "price", NEW.price,
                    "name", NEW.name,
                    "suggested_quantity", NEW.suggested_quantity,
                    "stock", NEW.stock,
                    "action", NEW.action,
                    "charge", NEW.charge,
                    "weight", NEW.weight,
                    "unit_factor", NEW.unit_factor,
                    "kit", NEW.kit,
                    "material", NEW.material,
                    "polarized", NEW.polarized,
                    "price_table", NEW.price_table,
                    "order_type", NEW.order_type,
                    "segment", NEW.segment,
                    "brand", NEW.brand,
                    "category", NEW.category,
                    "packaging_type", NEW.packaging_type,
                    "group_konnect", NEW.group_konnect,
                    "delivery_type", NEW.delivery_type,
                    "flavor", NEW.flavor,
                    "created_at", NEW.created_at,
                    "updated_at", NEW.updated_at
                ),
                NOW(),
                NOW()
            );
            END
        ');

        // Criação da trigger após a atualização
        DB::unprepared('
            CREATE TRIGGER product_log_after_update AFTER UPDATE ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO product_log (product_id, action, data, created_at, updated_at)
                VALUES (NEW.id, \'Update\', JSON_OBJECT(
                    "code", NEW.code,
                    "price", NEW.price,
                    "name", NEW.name,
                    "suggested_quantity", NEW.suggested_quantity,
                    "stock", NEW.stock,
                    "action", NEW.action,
                    "charge", NEW.charge,
                    "weight", NEW.weight,
                    "unit_factor", NEW.unit_factor,
                    "kit", NEW.kit,
                    "material", NEW.material,
                    "polarized", NEW.polarized,
                    "price_table", NEW.price_table,
                    "order_type", NEW.order_type,
                    "segment", NEW.segment,
                    "brand", NEW.brand,
                    "category", NEW.category,
                    "packaging_type", NEW.packaging_type,
                    "group_konnect", NEW.group_konnect,
                    "delivery_type", NEW.delivery_type,
                    "flavor", NEW.flavor,
                    "created_at", NEW.created_at,
                    "updated_at", NEW.updated_at
                ),
                NOW(),
                NOW()
            );
            END
        ');
    }

    public function down()
    {
        Schema::dropIfExists('product_log');
    }
};
