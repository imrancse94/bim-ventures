<?php


if (! function_exists('formatDatetime')) {

    function format_datetime($datetime, string $format = 'd-m-Y h:i:s A'): string
    {
        $result = "";
        if ($datetime instanceof \Carbon\Carbon) {
            $result = $datetime->format($format);
        } else {
            $result = \Illuminate\Support\Carbon::parse($datetime)->format($format);
        }
        return $result;
    }

}

if (!function_exists('generateUniqueId')) {

    function generateUniqueId()
    {
        return rand(0,100).rand(0,100).time();
    }
}

if (!function_exists('splitDate')) {

    function splitDate($date)
    {
       $formated_date =  date('Y-m-d',strtotime($date));

       $exploded = explode('-',$formated_date);

       return [
            'year'=>$exploded[0],
            'month'=>$exploded[1],
            'day'=>$exploded[2]
        ];
    }

}

if (!function_exists('getDateDifference')) {

    function getDateDifference($date1,$date2)
    {
        $date = \Illuminate\Support\Carbon::parse($date1);
        return  $date->diffInDays($date2);
    }
}

if (!function_exists('isPastDate')) {

    function isPastDate($date_string)
    {
        return \Illuminate\Support\Carbon::parse($date_string)->isPast();
       
    }
}


if (!function_exists('getSystemCurrentDateTime')) {

    function getSystemCurrentDateTime()
    {
        return \Illuminate\Support\Carbon::now();
       
    }
}

if (!function_exists('getTransactionStatus')) {

    function getTransactionStatus($status,$due_date)
    {
        $status_list = \App\Utils\TransactionStatus::STATUS_LIST;
   
        $paid_status = \App\Utils\TransactionStatus::PAID_STATUS;
        
        $outstanding_status = \App\Utils\TransactionStatus::OUTSTANDING_STATUS;
        
        $overdue_status = \App\Utils\TransactionStatus::OVERDUE_STATUS;
        
        if($status == $paid_status)
        {
            return $status_list[$status];
        }
       
        if(isPastDate($due_date) && $status == $outstanding_status)
        {
            return $status_list[$overdue_status];
        }

        return $status_list[$status];
    }
}

