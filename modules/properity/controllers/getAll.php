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
    public $electricity;
    public $internet;
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
    public $accountNumber;
    public $bill;
    public $receipt;
    public $bond;
}
function getAllProperties()
{
    global $wpdb;

    $getProperties = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM " . $wpdb->prefix . "alkamal_property"
    ));
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
        $property->rentValue = $porp->rentValue;
        $property->depositValue = $porp->depositValue;
        $property->meterPrice = $porp->meterPrice;
        $property->paperContractNumber = $porp->paperContractNumber;
        $property->digitlyContractNumber = $porp->digitlyContractNumber;
        $property->insurance = $porp->insurance;
        $property->commission = $porp->commission;
        $property->annualIncrease = $porp->annualIncrease;
        $images = array();
        foreach (explode(',', $porp->images) as $imageId) {
            $imageUrl = wp_get_attachment_url($imageId);
            array_push($images, $imageUrl);
        }
        $property->images = $images;

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
            $images = array();
            foreach (explode(',', $electricity->bill) as $billImageId) {
                $imageUrl = wp_get_attachment_url($billImageId);
                array_push($images, $imageUrl);
            }
            $electric->bill = $images;
            $images = array();
            foreach (explode(',', $electricity->receipt) as $receiptImageId) {
                $imageUrl = wp_get_attachment_url($receiptImageId);
                array_push($images, $imageUrl);
            }
            $electric->receipt = $images;
            $images = array();
            foreach (explode(',', $electricity->bond) as $bondImageId) {
                $imageUrl = wp_get_attachment_url($bondImageId);
                array_push($images, $imageUrl);
            }
            $electric->bond = $images;
            array_push($electricities, $electric);
        }

        $getInternets = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}alkamal_internet WHERE propertyId = {$porp->id}"
        );
        $net = $getInternets[0];
        $internet = new Internet();
        $internet->id = $net->id;
        $internet->propertyId = $net->propertyId;
        $internet->internetCompany = $net->internetCompany;
        $internet->accountNumber = $net->accountNumber;
        $internet->startAt = $net->startAt;
        $internet->endAt = $net->endAt;
        $internet->transactionNumber = $net->transactionNumber;
        $images = array();
        foreach (explode(',', $net->bill) as $billImageId) {
            $imageUrl = wp_get_attachment_url($billImageId);
            array_push($images, $imageUrl);
        }
        $internet->bill = $images;
        $images = array();
        foreach (explode(',', $net->receipt) as $receiptImageId) {
            $imageUrl = wp_get_attachment_url($receiptImageId);
            array_push($images, $imageUrl);
        }
        $internet->receipt = $images;
        $images = array();
        foreach (explode(',', $net->bond) as $bondImageId) {
            $imageUrl = wp_get_attachment_url($bondImageId);
            array_push($images, $imageUrl);
        }
        $internet->bond = $images;

        $property->electricity = $electricities;
        $property->internet = $internet;
        array_push($properties, $property);
    }
    return $properties;
}
