<?php

/**
 * Description of DateMethod
 *
 * @author vinay
 */
class DateMethod {

    Public Static Function GetCurrDate($Format = "Y-m-d H:i:s") {
        if ($Format == "Y-m-d") {
            return (date('Y-m-d'));
        } elseif ($Format == "Y-m-d H:i:s") {
            return (date('Y-m-d H:i:s'));
        } elseif ($Format == "d-m-Y") {
            return (date('d-m-Y'));
        } elseif ($Format == "d-m-Y H:i:s") {
            return (date('d-m-Y H:i:s'));
        }
        return null;
    }

    Public Static Function IsValidDate($Date, $Format = "Y-m-d H:i:s") {
        if (is_null($Date) || trim($Date) == '') {
            return false;
        }
        if ($Format == "Y-m-d" && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($Date))) {
            return true;
        } elseif ($Format == "Y-m-d H:i:s" && preg_match('/^\d{4}-\d{2}-\d{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', trim($Date))) {
            return true;
        } elseif ($Format == "d-m-Y" && preg_match('/^\d{2}-\d{2}-\d{4}$/', trim($Date))) {
            return true;
        } elseif ($Format == "d-m-Y H:i:s" && preg_match('/^\d{2}-\d{2}-\d{4} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', trim($Date))) {
            return true;
        }
        return false;
    }

    Public Static Function IsDate(&$fdate) {
        $fdate = trim($fdate);
        if (strlen($fdate) != 10) {
            return false;
        }
        $regs = array();
        if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $fdate, $regs)) {
            return checkdate($regs[2], $regs[3], $regs[1]); //checkdate(Month,Day,Year)
        } else {
            return false;
        }
    }

    Public Static Function GetDateFormate($Date) {
        if (is_null($Date) || trim($Date) == '') {
            return '';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($Date))) {
            return "Y-m-d";
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', trim($Date))) {
            return "Y-m-d H:i:s";
        } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', trim($Date))) {
            return "d-m-Y";
        } elseif (preg_match('/^\d{2}-\d{2}-\d{4} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', trim($Date))) {
            return "d-m-Y H:i:s";
        } else {
            return '';
        }
    }

    Public Static Function ChangeDateFormat($Date, $Format = "Y-m-d H:i:s") {
        if (is_null($Date) || trim($Date) == '') {
            return '';
        }
        if ($Format != "Y-m-d" && $Format != "Y-m-d H:i:s" && $Format != "d-m-Y" && $Format != "d-m-Y H:i:s") {
            return '';
        }
        $DArr = self::GetDateArray($Date);
        return date($Format, mktime($DArr['H'], $DArr['I'], $DArr['S'], $DArr['M'], $DArr['D'], $DArr['Y']));
    }

    Public Static Function GetDateArray($Date) {
        $ReturnArr = array();
        $Format = self::GetDateFormate($Date);
        if (trim($Format) == '') {
            $Format = "Y-m-d H:i:s";
            $Date = self::GetCurrDate("Y-m-d H:i:s");
        }
        if ($Format == "Y-m-d" || $Format == "Y-m-d H:i:s") {
            $ReturnArr['Y'] = substr(trim($Date), 0, 4);
            $ReturnArr['M'] = substr(trim($Date), 5, 2);
            $ReturnArr['D'] = substr(trim($Date), 8, 2);
        } elseif ($Format == "d-m-Y" || $Format == "d-m-Y H:i:s") {
            $ReturnArr['Y'] = substr(trim($Date), 6, 4);
            $ReturnArr['M'] = substr(trim($Date), 3, 2);
            $ReturnArr['D'] = substr(trim($Date), 0, 2);
        }
        if ($Format == "Y-m-d H:i:s" || $Format == "d-m-Y H:i:s") {
            $ReturnArr['H'] = substr(trim($Date), 11, 2);
            $ReturnArr['I'] = substr(trim($Date), 14, 2);
            $ReturnArr['S'] = substr(trim($Date), 17, 2);
        } else {
            $ReturnArr['H'] = "00";
            $ReturnArr['I'] = "00";
            $ReturnArr['S'] = "00";
        }
        return $ReturnArr;
    }

    Public Static Function AddMonth($Date, $NoOfMonth) {
        $Format = self::GetDateFormate($Date);
        if ($Format == '') {
            return $Date;
        }
        $DArr = self::GetDateArray($Date);
        return date($Format, mktime($DArr['H'], $DArr['I'], $DArr['S'], $DArr['M'] + $NoOfMonth, $DArr['D'], $DArr['Y']));
    }

    Public Static Function AddDate($Date, $NoOfDays) {
        $Format = self::GetDateFormate($Date);
        if ($Format == '') {
            return $Date;
        }
        $DArr = self::GetDateArray($Date);
        return date($Format, mktime($DArr['H'], $DArr['I'], $DArr['S'], $DArr['M'], $DArr['D'] + $NoOfDays, $DArr['Y']));
    }

    Public Static Function AddTime($Date, $TimeInSec) {
        $Format = self::GetDateFormate($Date);
        if ($Format == '') {
            return $Date;
        }
        $DArr = self::GetDateArray($Date);
        return date($Format, mktime($DArr['H'], $DArr['I'], $DArr['S'] + $TimeInSec, $DArr['M'], $DArr['D'], $DArr['Y']));
    }

    Public Static Function GetDiffInDate($Date1, $Date2, $DiffIn = 'D') {    // $Date1 - $Date2
        $Date_1 = self::GetDateArray($Date1);
        $Date_2 = self::GetDateArray($Date2);
        $Time1 = mktime($Date_1['H'], $Date_1['I'], $Date_1['S'], $Date_1['M'], $Date_1['D'], $Date_1['Y']);
        $Time2 = mktime($Date_2['H'], $Date_2['I'], $Date_2['S'], $Date_2['M'], $Date_2['D'], $Date_2['Y']);
        $Diff = $Time1 - $Time2;
        switch (strtoupper(trim($DiffIn))) {
            case 'Y': $Diff /= 365;
            case 'M': $Diff /= 30;
            case 'D': $Diff /= 24;
            case 'H': $Diff /= 60;
            case 'I': $Diff /= 60;
            case 'S':
            default: $Diff /= 1;
        }
        return $Diff;
    }

}
