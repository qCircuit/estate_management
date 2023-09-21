<?php

$table_columns_mapping = [
    "users" => [
        "first_name", "last_name", "password", "email", "created_at", "updated_at"
    ],
    "properties" => ["property_name", "description", "img", "created_by", "created_at", "updated_at"],
    "tenants" => ["tenant_name", "tenant_phone", "tenant_email", "created_by", "created_at", "updated_at"],
];