<?
/*
    Bitrix Offal Userdata v1.0 - https://github.com/max-kmb/offal
    Быстрая очистка 1С-Битрикс

    (c) 2020 Максим Кубрак - https://maksimkubrak.ru
    web@maksimkubrak.ru
*/
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;

CModule::IncludeModule("iblock");
?>
<div>
<?
$res = CIBlock::GetList(
   Array("ID"=>"ASC"),
   Array(), 
    true
);
if($USER->IsAdmin()) {
echo '<pre>';
while($ar_res = $res->Fetch())
    {
    $ib_id=$ar_res['ID'];
    $ib=$ib_id." ; ".$ar_res['IBLOCK_TYPE_ID']." ; ".$ar_res['CODE']." ; ".$ar_res['NAME'];
        echo "<b>IB: ".$ib."</b><br>";
    $properties = CIBlockProperty::GetList(Array("id"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$ib_id));
    while ($prop_fields = $properties->GetNext())
    {
        $prop_id=$prop_fields["ID"];
        echo "&ensp;&ensp;UF -> ; ".$prop_id." ; ".$prop_fields["CODE"]." ; ".$prop_fields["NAME"]."<br>";
        $property_enums = CIBlockPropertyEnum::GetList(Array("ID"=>"ASC"), Array("IBLOCK_ID"=>$ib_id, "PROPERTY_ID"=>$prop_id));
        while($enum_fields = $property_enums->GetNext())
            {
                  echo "&ensp;&ensp;&ensp;&ensp;UF -> PROPERTY => ; ".$enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br>";
            }
    }
    $arSelect = Array('ID', 'NAME');
    $arFilter = Array('IBLOCK_ID'=>$ib_id, 'ACTIVE'=>'Y', 'GLOBAL_ACTIVE'=>'Y');
    $section_res = CIBlockSection::GetList(Array('ID'=>'ASC'), $arFilter, true, $arSelect);
        while($ob = $section_res->GetNext())
        {
            echo "&ensp;&ensp;Section -> ; ".$ob['ID']." ; ".$ob['NAME']."<br>";
        }
    echo "<br>";
    }
echo '</pre>';
}
?>
</div>
