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
    public $landlord;
    public $paymentSystem;
    public $payments = array();
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

class Payment
{
    public $id;
    public $propertyId;
    public $amount;
    public $date;
}
function getAllProperties($body)
{
    global $wpdb;

    if (isset($body['id']) && !empty($body['id'])) {

        $getProperties = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . $wpdb->prefix . "alkamal_property" . " WHERE id = %d",
            $body['id']
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
            $property->paymentSystem = $porp->paymentSystem;
            if ($porp->landlordId) {
                $ll = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}alkamal_landlord WHERE id = {$porp->landlordId}");
                if (wp_get_attachment_url($ll->image) != false) {
                    $ll->image = wp_get_attachment_url($ll->image);
                }
                $property->landlord = $ll;
            }
            $images = array();
            foreach (explode(',', $porp->images) as $imageId) {
                if (wp_get_attachment_url($imageId) != false) {
                    $imageUrl = wp_get_attachment_url($imageId);
                    array_push($images, $imageUrl);
                }
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
                    if (wp_get_attachment_url($billImageId) != false) {

                        $imageUrl = wp_get_attachment_url($billImageId);
                        array_push($images, $imageUrl);
                    }
                }
                $electric->bill = $images;
                $images = array();
                foreach (explode(',', $electricity->receipt) as $receiptImageId) {
                    if (wp_get_attachment_url($receiptImageId) != false) {

                        $imageUrl = wp_get_attachment_url($receiptImageId);
                        array_push($images, $imageUrl);
                    }
                }
                $electric->receipt = $images;
                $images = array();
                foreach (explode(',', $electricity->bond) as $bondImageId) {
                    if (wp_get_attachment_url($bondImageId) != false) {

                        $imageUrl = wp_get_attachment_url($bondImageId);
                        array_push($images, $imageUrl);
                    }
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
                if (wp_get_attachment_url($billImageId) != false) {

                    $imageUrl = wp_get_attachment_url($billImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->bill = $images;
            $images = array();
            foreach (explode(',', $net->receipt) as $receiptImageId) {
                if (wp_get_attachment_url($receiptImageId) != false) {

                    $imageUrl = wp_get_attachment_url($receiptImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->receipt = $images;
            $images = array();
            foreach (explode(',', $net->bond) as $bondImageId) {
                if (wp_get_attachment_url($bondImageId) != false) {

                    $imageUrl = wp_get_attachment_url($bondImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->bond = $images;

            $property->electricity = $electricities;
            $property->internet = $internet;
            array_push($properties, $property);

            $payments = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM " . $wpdb->prefix . "alkamal_payment" . " WHERE propertyId = %d",
                $property->id
            ));

            $property->payments = $payments;
        }




        return $properties;
    } else {
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
            $property->paymentSystem = $porp->paymentSystem;
            if ($porp->landlordId) {
                $ll = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}alkamal_landlord WHERE id = {$porp->landlordId}");
                if (wp_get_attachment_url($ll->image) != false) {
                    $ll->image = wp_get_attachment_url($ll->image);
                }
                $property->landlord = $ll;
            }
            $images = array();
            foreach (explode(',', $porp->images) as $imageId) {
                if (wp_get_attachment_url($imageId) != false) {
                    $imageUrl = wp_get_attachment_url($imageId);
                    array_push($images, $imageUrl);
                }
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
                    if (wp_get_attachment_url($billImageId) != false) {

                        $imageUrl = wp_get_attachment_url($billImageId);
                        array_push($images, $imageUrl);
                    }
                }
                $electric->bill = $images;
                $images = array();
                foreach (explode(',', $electricity->receipt) as $receiptImageId) {
                    if (wp_get_attachment_url($receiptImageId) != false) {

                        $imageUrl = wp_get_attachment_url($receiptImageId);
                        array_push($images, $imageUrl);
                    }
                }
                $electric->receipt = $images;
                $images = array();
                foreach (explode(',', $electricity->bond) as $bondImageId) {
                    if (wp_get_attachment_url($bondImageId) != false) {

                        $imageUrl = wp_get_attachment_url($bondImageId);
                        array_push($images, $imageUrl);
                    }
                }
                $electric->bond = $images;
                array_push($electricities, $electric);
            }

            $getInternets = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}alkamal_internet WHERE propertyId = {$porp->id} "
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
                if (wp_get_attachment_url($billImageId) != false) {

                    $imageUrl = wp_get_attachment_url($billImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->bill = $images;
            $images = array();
            foreach (explode(',', $net->receipt) as $receiptImageId) {
                if (wp_get_attachment_url($receiptImageId) != false) {

                    $imageUrl = wp_get_attachment_url($receiptImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->receipt = $images;
            $images = array();
            foreach (explode(',', $net->bond) as $bondImageId) {
                if (wp_get_attachment_url($bondImageId) != false) {

                    $imageUrl = wp_get_attachment_url($bondImageId);
                    array_push($images, $imageUrl);
                }
            }
            $internet->bond = $images;

            $property->electricity = $electricities;
            $property->internet = $internet;
            array_push($properties, $property);

            $payments = $wpdb->get_results($wpdb->prepare(
                "SELECT * FROM " . $wpdb->prefix . "alkamal_payment" . " WHERE propertyId = %d",
                $property->id
            ));

            $property->payments = $payments;
        }




        return $properties;
    }
}
