<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 * @property int $positionMenu
 * @property int $positionIndex
 * @property int $positionCreate
 * @property int $positionView
 * @property int $positionUpdate
 * @property int $positionActive
 * @property int $positionBlocked
 * @property int $positionHistory
 *
 * @property int $workerMenu
 * @property int $workerIndex
 * @property int $workerCreate
 * @property int $workerView
 * @property int $workerUpdate
 * @property int $workerActive
 * @property int $workerBlocked
 * @property int $workerHistory
 *
 * @property int $workMenu
 * @property int $workIndex
 * @property int $workCreate
 * @property int $workView
 * @property int $workUpdate
 * @property int $workActive
 * @property int $workBlocked
 *
 * @property int $certificateMenu
 * @property int $certificateIndex
 * @property int $certificateCreate
 * @property int $certificateView
 * @property int $certificateUpdate
 * @property int $certificateActive
 * @property int $certificateBlocked
*
 * @property int $referenceMenu
 * @property int $referenceIndex
 * @property int $referenceCreate
 * @property int $referenceView
 * @property int $referenceUpdate
 * @property int $referenceActive
 * @property int $referenceBlocked
*
 * @property int $vaccinationMenu
 * @property int $vaccinationIndex
 * @property int $vaccinationCreate
 * @property int $vaccinationView
 * @property int $vaccinationUpdate
 * @property int $vaccinationActive
 * @property int $vaccinationBlocked
*
 * @property int $fileMenu
 * @property int $fileIndex
 * @property int $fileCreate
 * @property int $fileView
 * @property int $fileUpdate
 * @property int $fileActive
 * @property int $fileBlocked
 * @property int $fileDelete
 *
 * @property int $counterpartyMenu
 * @property int $counterpartyIndex
 * @property int $counterpartyCreate
 * @property int $counterpartyView
 * @property int $counterpartyUpdate
 * @property int $counterpartyActive
 * @property int $counterpartyBlocked
 * @property int $counterpartyDelete
 *
 * @property int $counterpartyFlMenu
 * @property int $counterpartyFlIndex
 * @property int $counterpartyFlCreate
 * @property int $counterpartyFlView
 * @property int $counterpartyFlUpdate
 * @property int $counterpartyFlActive
 * @property int $counterpartyFlBlocked
 * @property int $counterpartyFlDelete
 *
 * @property AuthItem $child0
 * @property AuthItem $parent0
 */
class AuthItemChild extends ActiveRecord
{
    public $positionMenu;
    public $positionIndex;
    public $positionCreate;
    public $positionView;
    public $positionUpdate;
    public $positionActive;
    public $positionBlocked;
    public $positionHistory;

    public $workerMenu;
    public $workerIndex;
    public $workerCreate;
    public $workerView;
    public $workerUpdate;
    public $workerActive;
    public $workerBlocked;
    public $workerHistory;

    public $workMenu;
    public $workIndex;
    public $workCreate;
    public $workView;
    public $workUpdate;
    public $workActive;
    public $workBlocked;

    public $certificateMenu;
    public $certificateIndex;
    public $certificateCreate;
    public $certificateView;
    public $certificateUpdate;
    public $certificateActive;
    public $certificateBlocked;

    public $referenceMenu;
    public $referenceIndex;
    public $referenceCreate;
    public $referenceView;
    public $referenceUpdate;
    public $referenceActive;
    public $referenceBlocked;

    public $vaccinationMenu;
    public $vaccinationIndex;
    public $vaccinationCreate;
    public $vaccinationView;
    public $vaccinationUpdate;
    public $vaccinationActive;
    public $vaccinationBlocked;

    public $fileMenu;
    public $fileIndex;
    public $fileCreate;
    public $fileView;
    public $fileUpdate;
    public $fileActive;
    public $fileBlocked;
    public $fileDelete;

    public $historyMenu;
    public $historyIndex;

    public $departmentMenu;
    public $departmentIndex;
    public $departmentCreate;
    public $departmentView;
    public $departmentUpdate;
    public $departmentActive;
    public $departmentBlocked;
    public $departmentHistory;

    public $divisionMenu;
    public $divisionIndex;
    public $divisionCreate;
    public $divisionView;
    public $divisionUpdate;
    public $divisionActive;
    public $divisionBlocked;
    public $divisionHistory;

    public $specializationMenu;
    public $specializationIndex;
    public $specializationCreate;
    public $specializationView;
    public $specializationUpdate;
    public $specializationActive;
    public $specializationBlocked;
    public $specializationHistory;

    public $referenceTypeMenu;
    public $referenceTypeIndex;
    public $referenceTypeCreate;
    public $referenceTypeView;
    public $referenceTypeUpdate;
    public $referenceTypeActive;
    public $referenceTypeBlocked;
    public $referenceTypeHistory;

    public $vaccineMenu;
    public $vaccineIndex;
    public $vaccineCreate;
    public $vaccineView;
    public $vaccineUpdate;
    public $vaccineActive;
    public $vaccineBlocked;
    public $vaccineHistory;

    public $counterpartyMenu;
    public $counterpartyIndex;
    public $counterpartyCreate;
    public $counterpartyView;
    public $counterpartyUpdate;
    public $counterpartyActive;
    public $counterpartyBlocked;
    public $counterpartyHistory;

    public $counterpartyAddressMenu;
    public $counterpartyAddressIndex;
    public $counterpartyAddressCreate;
    public $counterpartyAddressView;
    public $counterpartyAddressUpdate;
    public $counterpartyAddressActive;
    public $counterpartyAddressBlocked;

    public $counterpartyContactMenu;
    public $counterpartyContactIndex;
    public $counterpartyContactCreate;
    public $counterpartyContactView;
    public $counterpartyContactUpdate;
    public $counterpartyContactActive;
    public $counterpartyContactBlocked;

    public $counterpartyFlMenu;
    public $counterpartyFlIndex;
    public $counterpartyFlCreate;
    public $counterpartyFlView;
    public $counterpartyFlUpdate;
    public $counterpartyFlActive;
    public $counterpartyFlBlocked;
    public $counterpartyFlHistory;

    public $counterpartyFlPassportMenu;
    public $counterpartyFlPassportIndex;
    public $counterpartyFlPassportCreate;
    public $counterpartyFlPassportView;
    public $counterpartyFlPassportUpdate;
    public $counterpartyFlPassportActive;
    public $counterpartyFlPassportBlocked;

    public $counterpartyFlAddressMenu;
    public $counterpartyFlAddressIndex;
    public $counterpartyFlAddressCreate;
    public $counterpartyFlAddressView;
    public $counterpartyFlAddressUpdate;
    public $counterpartyFlAddressActive;
    public $counterpartyFlAddressBlocked;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
            [['positionIndex', 'positionMenu', 'positionCreate', 'positionView', 'positionUpdate', 'positionActive', 'positionBlocked', 'positionHistory'], 'integer'],
            [['workerIndex', 'workerMenu', 'workerCreate', 'workerView', 'workerUpdate', 'workerActive', 'workerBlocked', 'workerHistory'], 'integer'],
            [['workIndex', 'workMenu', 'workCreate', 'workView', 'workUpdate', 'workActive', 'workBlocked'], 'integer'],
            [['certificateIndex', 'certificateMenu', 'certificateCreate', 'certificateView', 'certificateUpdate', 'certificateActive', 'certificateBlocked'], 'integer'],
            [['referenceIndex', 'referenceMenu', 'referenceCreate', 'referenceView', 'referenceUpdate', 'referenceActive', 'referenceBlocked'], 'integer'],
            [['vaccinationIndex', 'vaccinationMenu', 'vaccinationCreate', 'vaccinationView', 'vaccinationUpdate', 'vaccinationActive', 'vaccinationBlocked'], 'integer'],
            [['fileIndex', 'fileMenu', 'fileCreate', 'fileView', 'fileUpdate', 'fileActive', 'fileBlocked', 'fileDelete'], 'integer'],
            [['historyMenu', 'historyIndex'], 'integer'],
            [['departmentIndex', 'departmentMenu', 'departmentCreate', 'departmentView', 'departmentUpdate', 'departmentActive', 'departmentBlocked', 'departmentHistory'], 'integer'],
            [['divisionIndex', 'divisionMenu', 'divisionCreate', 'divisionView', 'divisionUpdate', 'divisionActive', 'divisionBlocked', 'divisionHistory'], 'integer'],
            [['specializationIndex', 'specializationMenu', 'specializationCreate', 'specializationView', 'specializationUpdate', 'specializationActive', 'specializationBlocked', 'specializationHistory'], 'integer'],
            [['referenceTypeIndex', 'referenceTypeMenu', 'referenceTypeCreate', 'referenceTypeView', 'referenceTypeUpdate', 'referenceTypeActive', 'referenceTypeBlocked', 'referenceTypeHistory'], 'integer'],
            [['vaccineIndex', 'vaccineMenu', 'vaccineCreate', 'vaccineView', 'vaccineUpdate', 'vaccineActive', 'vaccineBlocked', 'vaccineHistory'], 'integer'],
            [['counterpartyIndex', 'counterpartyMenu', 'counterpartyCreate', 'counterpartyView', 'counterpartyUpdate', 'counterpartyActive', 'counterpartyBlocked', 'counterpartyHistory'], 'integer'],
            [['counterpartyAddressIndex', 'counterpartyAddressMenu', 'counterpartyAddressCreate', 'counterpartyAddressView', 'counterpartyAddressUpdate', 'counterpartyAddressActive', 'counterpartyAddressBlocked'], 'integer'],
            [['counterpartyContactIndex', 'counterpartyContactMenu', 'counterpartyContactCreate', 'counterpartyContactView', 'counterpartyContactUpdate', 'counterpartyContactActive', 'counterpartyContactBlocked'], 'integer'],
            [['counterpartyFlIndex', 'counterpartyFlMenu', 'counterpartyFlCreate', 'counterpartyFlView', 'counterpartyFlUpdate', 'counterpartyFlActive', 'counterpartyFlBlocked', 'counterpartyFlHistory'], 'integer'],
            [['counterpartyFlPassportIndex', 'counterpartyFlPassportMenu', 'counterpartyFlPassportCreate', 'counterpartyFlPassportView', 'counterpartyFlPassportUpdate', 'counterpartyFlPassportActive', 'counterpartyFlPassportBlocked'], 'integer'],
            [['counterpartyFlAddressIndex', 'counterpartyFlAddressMenu', 'counterpartyFlAddressCreate', 'counterpartyFlAddressView', 'counterpartyFlAddressUpdate', 'counterpartyFlAddressActive', 'counterpartyFlAddressBlocked'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * Gets query for [[Child0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }

    /**
     * Gets query for [[Parent0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    public function checked($key, $roleName)
    {
        return !empty($this->find()->where(['child' => $key])->andWhere(['parent' => $roleName])->all());
    }
}
