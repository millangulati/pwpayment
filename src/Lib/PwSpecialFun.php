<?php

/**
 * Description of PwSpecialFun
 *
 * @author vinay
 */
class PwSpecialFun {

    Private Static $CharStr = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmanopqrstuvwxyz@_#';
    Private Static $NLen = 9;
    Private Static $ANLen = 61;
    Private Static $ANSLen = 64;

    public static function ValidatePram($InputArr, $KeyArr) {
        try {
            foreach ((array) $KeyArr as $key => $type) {
                if (!isset($InputArr[$key]) || is_array($InputArr[$key]) || empty($InputArr[$key]) || !self::RegValidate($type, trim($InputArr[$key]))) {
                    throw new BadRequestException("Parameter " . (!isset($InputArr[$key]) || is_array($InputArr[$key]) ? "Required :: " : "Not In Proper format :: ") . $key);
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function ValidateOptional(&$InputArr, $KeyArr) {
        try {
            foreach ($KeyArr as $key => $type) {
                if (isset($InputArr[$key]) && !empty($InputArr[$key]) && (is_array($InputArr[$key]) || !self::RegValidate($type, trim($InputArr[$key])))) {
                    throw new BadRequestException("Parameter Not In Proper format :: " . $key);
                } else if (!isset($InputArr[$key])) {
                    $InputArr[$key] = '';
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public static function RegValidate($type, $val) {
        switch ($type) {
            case 'D': return preg_match('/^\d{4}-\d{2}-\d{2}$/', $val); //date Y-m-d
            case 'DT': return preg_match('/^\d{4}-\d{2}-\d{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/', $val); //date time Y-m-d H:i:s
            case 'A': return ctype_alpha($val); //alpha without space
            case 'AS': return preg_match('/^[A-Za-z ]+$/', $val); //alpha with space
            case 'AN': return ctype_alnum($val); //alpha numeric without space
            case 'ASN': return preg_match('/^[A-Za-z 0-9]+$/', $val); //alpha numeric with space
            case 'N': return ctype_digit($val); //numeric space
            case 'F': return preg_match('/^\d+\.?\d*$/', $val); //Float
            case 'FOD': return preg_match('/(^[0-9]+$)|(^[0-9]*\.[0-9]*$)/'); //Float for optionam dot
            case 'ANS': return preg_match('/^[A-Za-z 0-9_\-!:=?.,@#%\/\&\(\)\[\]]+$/', $val); //text
            case 'EMAIL':return preg_match('/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $val); //email
            case 'PAN': return self::validatePANNO($val); //PAN NO.
            case 'MNO': return self::IsValidMobile($val); //Mobile no
            case 'PIN': return preg_match('/^\d{6}$/', $val); //Pin No.
            case 'AU': return preg_match('/^[A-Za-z_]+$/', $val); //alpha with underscore
            case 'URL': return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $val); //URL
            case 'VER': return preg_match('/^\d{1,2}.\d{1,2}.\d{1,2}$/', $val); //Version No.
            default: return FALSE;
        }
    }

    public static function validatePANNO($PanNo) {
        $PANNO = strtoupper(trim($PanNo));
        if (strlen($PANNO) <> 10) {
            return false;
        }
        For ($key = 0; $key < strlen($PANNO); $key++) {
            $val = ord($PANNO{$key});
            if (($key == 9 || $key <= 4) && ($val < 65 || $val > 90)) {
                return false;
            } elseif ($key > 4 && $key <= 8 && ($val < 48 || $val > 57)) {
                return false;
            } elseif ($key == 3 && !strstr(",A,B,C,F,G,H,J,L,P,T,", "," . $PANNO{$key} . ",")) {
                return false;
            }
        }
        return true;
    }

    public static function IsValidMobile($mno) {
        $m = substr($mno, -10);
        $e = substr($mno, 0, -10);
        if (strlen($e) > 3 || !in_array($e, array('', '0', '91', '+91', '091'))) {
            return FALSE;
        }
        if (!in_array(substr($m, 0, 1), array('7', '8', '9'))) {
            return FALSE;
        }
        return preg_match('/^\d{10}$/', $m);
    }

    public static function Convert_num2str($number_str) {
        $data = trim($number_str);
        $no = intval($data);
        $no_of_digits = strlen($data);
        $tStr = "";
        While ($no_of_digits > 7) {
            $no = substr($data, -7);
            $data = substr($data, 0, strlen($data) - 7);
            $tStr = " Crore " . trim(self::calculate_num2str($no)) . $tStr;
            $no_of_digits = $no_of_digits - 7;
        }
        $no = intval($data);
        $tStr = self::calculate_num2str($no) . $tStr;
        return trim($tStr);
    }

    private static function calculate_num2str($no_send) {
        $units = array(0 => 'Zero', 1 => '', 2 => 'Ten', 3 => 'Hundred', 4 => 'Thousand', 5 => 'Thousand', 6 => 'Lakh', 7 => 'Lakh', 8 => 'Crore', 9 => 'Crore');
        $nos = array(0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Ninteen', 20 => 'Twenty');
        $nos_sec = array(2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty', 6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninty');
        $no = $no_send;
        $no_of_digits = strlen($no);
        $tStr = "";
        for ($i = $no_of_digits; $i >= 1; $i--) {
            $X = substr($no, $no_of_digits - $i, 1);
            if ($X > 0) {
                if ($i < 3) {
                    $no1 = substr($no, $no_of_digits - $i);
                    if ($no1 > 20) {
                        $tStr = $tStr . " " . $nos_sec[$X];
                    } else if (!($i == 1 && $no1 == 0)) {
                        $tStr = $tStr . " " . $nos[$no1];
                        break;
                    }
                } else {
                    if ($i == 3) {
                        $tStr = $tStr . " " . $nos[$X] . " " . $units[$i];
                    } elseif ((($i - 4) % 2) == 0) {
                        $tStr = $tStr . " " . $nos[$X] . " " . $units[$i];
                    } else {
                        $no1 = substr($no, $no_of_digits - $i, 2);
                        if ($no1 > 20) {
                            $tStr = $tStr . " " . $nos_sec[$X];
                        } else {
                            $tStr = $tStr . " " . $nos[$no1] . " " . $units[$i];
                            $i = $i - 1;
                        }
                    }
                }
            }
        }
        return $tStr;
    }

    public static function GetCurFinYear() {
        return date('m') > 3 ? date('Y') : date('Y') - 1;
    }

    public static function GeneratePasswd($PasswdLen, $Type = '') {
        if (trim($Type) == 'N') {
            $CharLen = self::$NLen;
        } elseif (trim($Type) == 'AN') {
            $CharLen = self::$ANLen;
        } else {
            $CharLen = self::$ANSLen;
        }
        $PasswdStr = "";
        while (strlen($PasswdStr) < $PasswdLen) {
            $RandChar = substr(self::$CharStr, mt_rand(0, $CharLen), 1);
            if (strpos($PasswdStr, $RandChar) !== false) {
                continue;
            }
            $PasswdStr .= $RandChar;
        }
        return $PasswdStr;
    }

}
