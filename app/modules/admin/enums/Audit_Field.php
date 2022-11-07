<?php

namespace crudle\app\admin\enums;


class Audit_Field
{
    const CreatedAt = 'created_at';
    const CreatedBy = 'created_by';
    const UpdatedAt = 'updated_at';
    const UpdatedBy = 'updated_by';

    public static function enums()
    {
        return [
            self::CreatedAt,
            self::CreatedBy,
            self::UpdatedAt,
            self::UpdatedBy,
        ];
    }
}
