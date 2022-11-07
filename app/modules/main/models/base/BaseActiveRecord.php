<?php

namespace crudle\app\main\models\base;

use crudle\app\main\enums\Type_Link;
use crudle\app\main\enums\Type_Mixed_Value;
use crudle\app\main\enums\Type_Model_Id;
use crudle\app\main\enums\Type_Relation;
use crudle\app\main\enums\Type_View;
use crudle\app\setup\enums\Type_Permission;
use crudle\app\main\models\LayoutSettingsForm;
use crudle\app\main\models\ListViewSettingsForm;
use crudle\app\main\models\Setup;
// use crudle\app\setup\models\ListViewSettingsForm;
// use crudle\app\setup\models\Setup;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;

/**
 * This is the base model class for all other ActiveRecord models.
 */
abstract class BaseActiveRecord extends ActiveRecord implements ActiveRecordInterface
{
    const SpaceChar = ' ';

    public $isCopyRecord = false;
    public $copyModel; // use to load source model
    public $listSettings;
    public $settings = null;
    private $_changedValues;

    public function init()
    {
        parent::init();
        $this->listSettings = new ListViewSettingsForm();
        // $this->listSettings->listIdAttribute = 'id';
    }

    public static function dbTableSchema()
    {
        return Yii::$app->db->getTableSchema(self::tableName());
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                // 'attributes' => [
                //     ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                //     ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                // ],
                'value' => function ($event) {
                    if (is_a( Yii::$app, 'yii\console\Application' ))
                        return $this->updated_by = $this->created_by; // NOT $this->id since it could be non-user record
                    else // (default)
                        return $this->updated_by = Yii::$app->user->id; // Yii::$app->get('user')->id;
                },
            ],
            [
                'class' => TimestampBehavior::class,
                // 'attributes' => [
                //     ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                //     ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                // ],
                'value' => function ($event) {
                    return new \yii\db\Expression('NOW()');
                },
            ]
        ];
    }

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'trim'],
            [[
                'status',
                'title',
                'created_at', // YYYY-MM-DD HH:MM:SS
                'updated_at', // YYYY-MM-DD HH:MM:SS
            ], 'safe'],
            [['id', 'created_by', 'updated_by'], 'string', 'max' => 140],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'No.'),
            'status' => Yii::t('app', 'Status'),
            'title' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public static function findExportTemplateData($columnNames)
    {
        $query = self::find()->select($columnNames);
        // check if join key exists and add columns here
        // if (isset($columnNames['join']))
        //     $query->joinWith($columnNames['join']['relTable'], true, 'INNER JOIN');
        // $query->join(
        //             'INNER JOIN', $columnNames['join']['relTable'],
        //                 "{$columnNames['join']['pkColumn']} = {$columnNames['join']['fkColumn']}"
        //         );

        // ... LEFT JOIN `post` ON `post`.`user_id` = `user`.`id`
        // $query->join('LEFT JOIN', 'post', 'post.user_id = user.id');

        // [$joinType, $tableName, $joinCondition]

        return $query->asArray()->all();
    }

    public static function loadDuplicateValues($fromModel, $toModel)
    {
        $filterAttributes = [
            'id',
            'status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];

        foreach ($fromModel->attributes as $attribute => $value) {
            if (in_array($attribute, $filterAttributes))
                continue;
            $toModel->{$attribute} = $value;
        }

        return $toModel;
    }

    public function valuesChanged()
    {
        $countChangedValues = 0;
        // compare old and new attribute values
        foreach ($this->oldAttributes as $name => $oldValue) {
            $newValue = $this->$name;
            if (is_object($newValue)) // avoid updated_at is yii\db\Expression object
                continue;
            if (in_array($name, $this::mixedValueFields()))
            {
                $oldValue = $this->getReformattedMixedValue($name, $oldValue);
                $newValue = $this->getReformattedMixedValue($name, $newValue);
                $unchanged = $this->compareMixedValues($name, $oldValue, $newValue);
                if ($unchanged)
                    continue;
            }
            if ($newValue == $oldValue)
                continue;
            // else
            $this->_changedValues .= $this->getAttributeLabel($name) . ' from ' . $oldValue . ' to ' . $newValue . ', ';
            $countChangedValues += 1;
        }

        return $countChangedValues > 0;
    }

    public function getChangedValues()
    {
        return $this->_changedValues;
    }

    public function getReformattedMixedValue($type, $value)
    {
        switch ($type)
        {
            case Type_Mixed_Value::CommaSeparated:
                if (!empty($value) && is_array($value))
                    return implode(',', $value);
                if (!empty($value) && !is_array($value))
                    return $value;
            default:
        }
    }

    public function compareMixedValues($type, $oldValue, $newValue)
    {
        switch ($type)
        {
            case Type_Mixed_Value::CommaSeparated:
                if (!empty($newValue) && is_array($newValue))
                    $newValue = implode(',', $newValue);
                return $newValue == $oldValue;
            default:
        }
    }

    public function getLayoutSettings($attribute)
    {
        return null;
        // $settings = Setup::getSettings( LayoutSettingsForm::class );
        // return $settings->$attribute;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
            return false;

        // if (! $this->isNewRecord )
        //     if (! $this->valuesChanged()) // !! run as validation check instead
        //         return false;
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterFind()
    {
        return parent::afterFind();
    }

    // ActiveRecord Interface
    public static function selectableItemsConfig()
    {
        return [
            // 'itemsModelClass' => '',
            // 'keyAttribute' => 'id', // default - must exist in source tables
            // 'valueAttribute' => 'description', // default if not overridden
            // 'groupAttribute' => null,
            // 'displayLabel' => null,
            // 'filters' => [],
            // 'sortOrder' => null, // 'description ASC',
            // 'fetchAsArray' => true,
            // 'mapListResult' => true,
            // 'addEmptyFirstItem' => true, // only applicable if 'mapListResult' == true
            // 'addSelectedFieldValue' => true, // only if model->isNewRecord == false
            // 'applyListModelFilters' => true,
            // 'addAdvancedSearchLink' => false, // loads advanced search modal form
            // 'addCreateListItemLink' => false, // loads quick form modal if exists
            // 'refreshListItemsAfterCreate' => true,
            // 'selectAddedItemAfterRefresh' => true,
        ];
    }

    public static function enums()
    {
    }

    public static function relations()
    {
        return [];
    }

    public static function hasRelations()
    {
        return count(self::relations()) > 0;
    }

    public function links($type, $includeEmpty = false)
    {
        $relations = [];
        foreach ($this::relations() as $relationId => $relationDetail) {
            if (!is_array($relationDetail))
                continue;
            // if ($relationDetail['type'] == Type_Relation::ParentModel ||
            //     $relationDetail['type'] == Type_Relation::InlineModel)
            //     continue;

            switch ($type) {
                // case Type_Link::Query:
                //     $link = 'get' . Inflector::camelize($relationId);
                //     $models = $this->$link();
                //     break;
                default: // Type_Link::Model:
                    $link = $relationId;
                    $models = $this->$link;
            }
            // $formName = StringHelper::basename($relationDetail['class']);
            if (!empty($models) || (empty($models) && $includeEmpty))
                $relations[$relationId] = $models;
        }

        return $relations;
    }

    public function linksCount()
    {
        $count = 0;
        foreach ($this::relations() as $relationId => $relationClass) {
            $relation = 'get' . Inflector::camelize($relationId);
            $count += $this->$relation()->count();
        }

        return $count;
    }

    public function hasLinks()
    {
        return $this->linksCount() > 0;
    }

    public static function authRules()
    {
    }

    public static function auditTableColumns()
    {
    }

    public static function customFields()
    {
    }

    public function hasMixedValueFields()
    {
    }

    public static function mixedValueFields()
    {
        return [
        ];
    }

    public function autoSuggestId()
    {
        $query = $this::find();
        if (!empty($this::autoSuggestFilters()))
            foreach ($this::autoSuggestFilters() as $filterAttribute)
                $query->andWhere([$filterAttribute => $this->{$filterAttribute}]);

        switch ($this::autoSuggestIdType()) {
            // case Type_Model_Id::UniqueIncrementedCount:
            //     $count = $query->count();
            //     return $count += 1;

            // case Type_Model_Id::UniqueIncrementedValue:
            //     // TODO: sorting does not work since column data type is varchar
            //     $model = $query->orderBy($this->autoSuggestAttribute() . ' DESC')->one();
            //     return $model->{$this->autoSuggestAttribute()} + 1;

            // case Type_Model_Id::GeneratedUuid:
            //     $uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
            //     return $uuid;

            default:
                return null; // ?
        }
    }

    public static function autoSuggestIdValue()
    {
        return true;
    }

    public static function autoSuggestIdType()
    {
        // return Type_Model_Id::UniqueIncrementedCount;
    }

    public static function autoSuggestFilters()
    {
        return [];
    }

    public static function autoSuggestAttribute()
    {
        return 'id';
    }

    public static function foreignKeyAttribute()
    {
    }

    public static function allowListView()
    {
        return true;
    }

    public static function viewType()
    {
        return [
            Type_View::List,
            Type_View::Form,
        ];
    }

    public static function moduleType()
    {}
}