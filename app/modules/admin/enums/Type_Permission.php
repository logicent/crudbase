<?php

namespace crudle\app\admin\enums;

class Type_Permission
{
    // Basic CRUD operations
    const Create = 'Create'; // and Duplicate
    const List   = 'List';
    const Read   = 'Read';
    const Update = 'Update'; // Write
    const Delete  = 'Delete';
    // Data operations
    const Export = 'Export';
    const Import = 'Import';

    public static function enums( $group = Permission_Group::All )
    {
        switch ( $group )
        {
            case Permission_Group::Crud:
                return self::_crudEnums();

            case Permission_Group::Data:
                return self::_dataEnums();

            default: // self::All
                return array_merge(
                        self::_crudEnums(),
                        self::_dataEnums(),
                    );
        }
    }

    private static function _crudEnums()
    {
        return [
            self::Create => self::Create,
            self::List   => self::List,
            self::Read   => self::Read,
            self::Update => self::Update,
            self::Delete => self::Delete,
        ];
    }

    private static function _dataEnums()
    {
        return [
            self::Export => self::Export,
            self::Import => self::Import,
        ];
    }
}