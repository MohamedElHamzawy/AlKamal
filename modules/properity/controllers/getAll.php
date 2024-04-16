<?php
class Property
{
    public $id;
    public $propertyName;
    public $address;
    public $area;
    public $status;
    public $startAt;
    public $endAt;
    public $images;
    public $rentValue;
    public $depositValue;
    public $meterPrice;
    public $paperContractNumber;
    public $digitlyContractNumber;
    public $insurance;
    public $commission;
    public $annualIncrease;
    public $electricities;
    public $internets;
}

class Electricity
{
    public $id;
    public $propertyId;
    public $sourceOfElectricity;
    public $electricCounterNumber;
    public $accountNumber;
    public $bill;
    public $receipt;
    public $bond;
}

class Internet
{
    public $id;
    public $propertyId;
    public $internetCompany;
    public $startAt;
    public $endAt;
    public $transactionNumber;
    public $bill;
    public $receipt;
    public $bond;
}
function getAllProperties()
{
    global $wpdb;

    $getProperties = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}alkamal_property"
    );
    $properties = array();
    foreach ($getProperties as $porp) {
        $property = new Property();
        $property->id = $porp->id;
        $property->propertyName = $porp->propertyName;
        $property->address = $porp->address;
        $property->area = $porp->area;
        $property->status = $porp->status;
        $property->startAt = $porp->startAt;
        $property->endAt = $porp->endAt;
        $property->images = $porp->images;
        $property->rentValue = $porp->rentValue;
        $property->depositValue = $porp->depositValue;
        $property->meterPrice = $porp->meterPrice;
        $property->paperContractNumber = $porp->paperContractNumber;
        $property->digitlyContractNumber = $porp->digitlyContractNumber;
        $property->insurance = $porp->insurance;
        $property->commission = $porp->commission;
        $property->annualIncrease = $porp->annualIncrease;

        $getElectricities = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}alkamal_electricity WHERE propertyId = {$porp->id}"
        );
        $electricities = array();
        foreach ($getElectricities as $electricity) {
            $electric = new Electricity();
            $electric->id = $electricity->id;
            $electric->propertyId = $electricity->propertyId;
            $electric->sourceOfElectricity = $electricity->sourceOfElectricity;
            $electric->electricCounterNumber = $electricity->electricCounterNumber;
            $electric->accountNumber = $electricity->accountNumber;
            $electric->bill = $electricity->bill;
            $electric->receipt = $electricity->receipt;
            $electric->bond = $electricity->bond;
            array_push($electricities, $electric);
        }

        $getInternets = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}alkamal_internet WHERE propertyId = {$porp->id}"
        );
        $internets = array();
        foreach ($getInternets as $internet) {
            $internet = new Internet();
            $internet->id = $internet->id;
            $internet->propertyId = $internet->propertyId;
            $internet->internetCompany = $internet->internetCompany;
            $internet->startAt = $internet->startAt;
            $internet->endAt = $internet->endAt;
            $internet->transactionNumber = $internet->transactionNumber;
            $internet->bill = $internet->bill;
            $internet->receipt = $internet->receipt;
            $internet->bond = $internet->bond;
            array_push($internets, $internet);
        }

        $property->electricities = $electricities;
        $property->internets = $internets;
        array_push($properties, $property);
    }
    return $properties;
}
