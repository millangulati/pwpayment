<?php

App::uses('AppModel', 'Model');

/**
 * Description of BankMaster
 *
 * @author vinay
 */
class BankStatement extends AppModel {

    public $useTable = 'bank_statement_schema';
    public $primaryKey = 'serno';

    public function importStatementFile($inputFileNames, $statementDate, $bankAccoutnNo) {
        $title = '';
        $count = 0;
        $resultData = array();
        App::import("vendor", "excel/PHPExcel");
        $PHPExcel = new PHPExcel();
        if (!is_array($inputFileNames))
            $inputFileNames = array($inputFileNames);
        //get All banks
        $BankMaster = ClassRegistry::init("BankMaster");
        $BankMasterDetails = $BankMaster->find("list", array("fields" => "bankcode"));
        foreach ($inputFileNames AS $inputFileName) {
            try {
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    unlink($inputFileName);
                } catch (Exception $e) {
                    throw new Exception('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
                $title = $inputFileName;
                $header = array();
                $dataDetail = array();
                //check with which bank current sheet is related to
                foreach ($BankMasterDetails AS $id => $code) {
                    if (stripos($title, $code . ".xls") !== false) {
                        //if bank detected for sheet than get banks schema
                        $this->setSource("bank_statement_schema");
                        $schemaDetail = $this->find("all", array("conditions" => array("bankid" => $id)));
                        foreach ($schemaDetail AS $val) {
                            $val = $val[$this->name];
                            $header[$val["column_no"] - 1] = $val["column_name"];
                            $dataDetail[$val["column_name"]] = array("type" => strtolower(str_replace(" ", "_", $val["column_type"])), "datatype" => $val["column_data_type"]);
                        }
                        break;
                    }
                }
                if (count($header) === 0)
                    throw new Exception("Schema Not Found For File $title.$inputFileName");
                $insertData = array();
                //  Loop through each sheet of the workbook in turn
                for ($sheetno = 0; $sheetno < $objPHPExcel->getSheetCount(); $sheetno++) {
                    $sheet = $objPHPExcel->getSheet($sheetno);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();
                    //  Loop through each row of the worksheet in turn
                    $sheetData = array();
                    for ($row = 1; $row <= $highestRow; $row++) {
                        if ($code == "AXIS" || $code == "BOM" || $code == "ICIC" || $code == 'HDFC')
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, TRUE);
                        else
                            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $sheetData[$row] = array();
                        foreach ($rowData[0] as $k => $v) {
                            if (!empty($v)) {
                                $sheetData[$row][$k] = str_replace("-", "", trim($v));
                            }
                        }
                    }
                    //check if the statment header in the sheets matches with the one in schema
                    $hederFoundFlag = false;
                    $dataindex = 1;

                    $flagAcc = 0;
                    foreach ($sheetData AS $val) {
                        if (in_array($bankAccoutnNo, $val))
                            $flagAcc++;
                        if ($flagAcc == 0) {
                            foreach ($val as $v) {
                                if (strpos($v, $bankAccoutnNo) !== false)
                                    $flagAcc++;
                            }
                        }
                    }
                    if ($flagAcc == 0)
                        throw new Exception("Invalid Account Number");
                    foreach ($sheetData AS $val) {
                        $dataindex++;
                        if ($code == "AXIS") {
                            unset($val[0]);
                            //unset($val[7]);
                        }
                        if ($code == "BOB") {
                            unset($val[0]);
                            unset($val[7]);
                        }
                        if ($code == "SBI" || $code == "BOM")
                            unset($val[1]);
                        if ($code == "HDFC") {
                            unset($val[1]);
                            //unset($val[2]);
                        }
                        if ($code == "ICIC") {
                            unset($val[0]);
                            unset($val[2]);
                            unset($val[6]);
                            unset($val[7]);
                        }
                        if ($code == 'YESB') {
                            unset($val[6]);
                        }
                        if ($code == 'CANB') {
                            unset($val[4]);
                        }
                        if ($val == $header) {
                            //if (array_combine(range(1, count($val)), array_values($val)) == $header) {
                            $hederFoundFlag = true;
                            break;
                        }
                    }
                    if (!$hederFoundFlag) {
                        throw new Exception("Invalid Data Found In File(1): '$title' sheet:" . $sheet->getTitle());
                    }
                    //iterate sheet from the row next to header to the highest row
                    for ($i = $dataindex; $i <= $highestRow; $i++) {
                        $emptyRowFlag = true;
                        //if row is empty then continue loop
                        foreach ($sheetData[$i] As $chkval) {
                            if (!empty($chkval)) {
                                $emptyRowFlag = false;
                                break;
                            }
                        }
                        if ($emptyRowFlag)
                            continue;
                        $data = array("bankid" => $schemaDetail[0][$this->name]["bankid"], "bankname" => $schemaDetail[0][$this->name]["bankname"], "statement_date" => $statementDate, "transaction_date" => $statementDate, "bank_account_no" => $bankAccoutnNo);
                        if ($schemaDetail[0][$this->name]["bankid"] == 3 || $schemaDetail[0][$this->name]["bankid"] == 7) {
                            $sheetData[$i][7] = str_replace(",", "", $sheetData[$i][7]);
                            $sheetData[$i][7] = trim($sheetData[$i][7]);
                            if (trim($sheetData[$i][7]) !== '' && !is_numeric($sheetData[$i][7]))
                                throw new Exception("Invalid Data Found " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][7] . "(Not Numeric). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                            if (strtoupper(trim($sheetData[$i][6])) == "CR")
                                $data["credit_amount"] = $sheetData[$i][7];
                            else if (strtoupper(trim($sheetData[$i][6])) == "DR")
                                $data["debit_amount"] = $sheetData[$i][7];
                            else
                                throw new Exception("Invalid Data Found Cr/Dr=" . $sheetData[$i][7] . " [File: '$title' sheet:" . $sheet->getTitle() . "].");
                        }
                        if ($schemaDetail[0][$this->name]["bankid"] == 10) {
                            if (isset($sheetData[$i][4])) {
                                $sheetData[$i][4] = str_replace(' ', '', $sheetData[$i][4]);
                                $sheetData[$i][4] = str_replace('-', '0', $sheetData[$i][4]);
                                $sheetData[$i][4] = rtrim($sheetData[$i][4]);
                                $sheetData[$i][4] = ltrim($sheetData[$i][4]);
                                $sheetData[$i][4] = intval(trim($sheetData[$i][4]));
                                if (!is_numeric($sheetData[$i][4]))
                                    throw new Exception("Invalid Data Found(Debit) =" . $sheetData[$i][4] . "(Not Numeric111). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                            }
                            if (isset($sheetData[$i][5])) {
                                $sheetData[$i][5] = str_replace(' ', '', $sheetData[$i][5]);
                                $sheetData[$i][5] = str_replace('-', '0', $sheetData[$i][5]);
                                $sheetData[$i][5] = rtrim($sheetData[$i][5]);
                                $sheetData[$i][5] = ltrim($sheetData[$i][5]);
                                $sheetData[$i][5] = intval(trim($sheetData[$i][5]));
                                if (!is_numeric($sheetData[$i][5]))
                                    throw new Exception("Invalid Data Found(Credit) =" . $sheetData[$i][5] . "(Not Numeric). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                            }
                        }

                        //traverse columns of row and check data type of column and validate it
                        foreach ($header AS $index => $headerval) {
                            $dataConstraints = explode(":", $dataDetail[$headerval]["datatype"]);
                            if (empty($sheetData[$i][$index]))
                                $sheetData[$i][$index] = "";

                            /*  for date & time */
                            if (trim(strtoupper($dataConstraints[0])) == "DATE") {
                                if (!empty($sheetData[$i][$index])) {
                                    if ($code == "AXIS") {
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d', strtotime(str_replace("'", "", $sheetData[$i][$index])));
                                    } else if ($code == 'BOM') {
                                        $dr = explode('/', $sheetData[$i][$index]);
                                        $data[$dataDetail[$headerval]["type"]] = $dr[2] . '-' . $dr[1] . '-' . $dr[0];
                                    } else if ($code == 'ICIC' || $code == 'HDFC' || $code == 'PNB') {
                                        $dr = explode('/', trim($sheetData[$i][$index]));
                                        /* if(count($dr)<3)
                                          $dr = explode('-', trim($sheetData[$i][$index]));
                                          if(count($dr) < 3)
                                          throw new Exception("Invalid Data Found"); */
                                        $data[$dataDetail[$headerval]["type"]] = $dr[2] . '-' . $dr[1] . '-' . $dr[0];
                                    } else
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($sheetData[$i][$index]));
                                } else {
                                    $data[$dataDetail[$headerval]["type"]] = "0000-00-00";
                                }
                            } elseif (trim(strtoupper($dataConstraints[0])) == "DATETIME") {
                                if (!empty($sheetData[$i][$index])) {

                                    if ($code == "AXIS" || $code == "BOM")
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d H:i:s', strtotime($sheetData[$i][$index]));
                                    else if (/* $code == 'ICIC' || */$code == 'HDFC') {
                                        $TTT = explode(' ', trim($sheetData[$i][$index]));
                                        $dr = explode('/', $TTT[0]);
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d', strtotime($dr[2] . '-' . $dr[0] . '-' . $dr[1]));
                                    } else if ($code == 'ICIC') {
                                        $dr = explode(' ', trim($sheetData[$i][$index]));
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d', strtotime(substr($dr[0], 0, 2) . '-' . substr($dr[0], 2, 2) . '-' . substr($dr[0], 4, 4)));
                                    } else
                                        $data[$dataDetail[$headerval]["type"]] = date('Y-m-d H:i:s', PHPExcel_Shared_Date::ExcelToPHP($sheetData[$i][$index]));
                                } else {
                                    $data[$dataDetail[$headerval]["type"]] = "0000-00-00 00:00:00";
                                }
                            }
                            if (trim(strtoupper($dataConstraints[0])) == "AN") {
                                // if( !ctype_alnum($sheetData[$i][$index]) )
                                //     throw new Exception("Invalid Data Found ".$dataDetail[ $headerval ]["type"]."=".$sheetData[$i][$index]."(Not Alpha-Numeric).");
                                if ($dataConstraints[1] != 0 && strlen($sheetData[$i][$index]) < $dataConstraints[1])
                                    throw new Exception("Invalid Data Found(2) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Minimum Length Should Be " . $dataConstraints[1] . ") [File: '$title' sheet:" . $sheet->getTitle() . "].");
                                if ($dataConstraints[2] != 0 && strlen($sheetData[$i][$index]) > $dataConstraints[1])
                                    throw new Exception("Invalid Data Found (3)" . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Length Should Not Exceed " . $dataConstraints[2] . " Characters) [File: '$title' sheet:" . $sheet->getTitle() . "].");
                                $data[$dataDetail[$headerval]["type"]] = $sheetData[$i][$index];
                            }

                            elseif (trim(strtoupper($dataConstraints[0])) == "A") {
                                if (!ctype_alpha($sheetData[$i][$index]))
                                    throw new Exception("Invalid Data Found(4) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Not Alphabetic) [File: '$title' sheet:" . $sheet->getTitle() . "].");
                                if ($dataConstraints[1] != 0 && strlen($sheetData[$i][$index]) < $dataConstraints[1])
                                    throw new Exception("Invalid Data Found(5) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Minimum Length Should Be " . $dataConstraints[1] . ") [File: '$title' sheet:" . $sheet->getTitle() . "].");
                                if ($dataConstraints[2] != 0 && strlen($sheetData[$i][$index]) > $dataConstraints[1])
                                    throw new Exception("Invalid Data Found(6) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Length Should Not Exceed " . $dataConstraints[2] . " Characters) [File: '$title' sheet:" . $sheet->getTitle() . "].");
                                $data[$dataDetail[$headerval]["type"]] = $sheetData[$i][$index];
                            }

                            elseif (trim(strtoupper($dataConstraints[0])) == "DOUBLE") {
                                $sheetData[$i][$index] = str_replace(",", "", $sheetData[$i][$index]);
                                $sheetData[$i][$index] = str_replace(" ", "", $sheetData[$i][$index]);
                                /*                                 * *** check CR And DR for -/+ sign **************** */
                                $sheetData[$i][$index] = str_replace(array('cr.', 'Cr.', 'CR.', "CR", 'cr', 'Cr'), array('', '', '', '', '', ''), $sheetData[$i][$index]);
                                $sheetData[$i][$index] = str_replace(array('dr.', 'Dr.', 'DR.', "DR", 'dr', 'Dr'), array('', '', '', '', '', ''), $sheetData[$i][$index]);
                                $sheetData[$i][$index] = trim($sheetData[$i][$index]);
                                if (trim($sheetData[$i][$index]) !== '' && !is_numeric($sheetData[$i][$index]))
                                    throw new Exception("Invalid Data Found(7) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Not Numeric). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                                if ($dataConstraints[1] > 0 && strlen($sheetData[$i][$index]) < $dataConstraints[1])
                                    throw new Exception("Invalid Data Found(8) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Should Not Be Less Than " . $dataConstraints[1] . "). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                                if ($dataConstraints[2] > 0 && strlen($sheetData[$i][$index]) > $dataConstraints[1])
                                    throw new Exception("Invalid Data Found(9) " . $dataDetail[$headerval]["type"] . "=" . $sheetData[$i][$index] . "(Should Be Greater Than " . $dataConstraints[2] . "). [File: '$title' sheet:" . $sheet->getTitle() . "]");
                                $data[$dataDetail[$headerval]["type"]] = $sheetData[$i][$index];
                            }
                            if (empty($data[$dataDetail[$headerval]["type"]])) {
                                unset($data[$dataDetail[$headerval]["type"]]); //  =   "";
                            }
                        }
                        if (isset($data['transaction_type'])) {
                            if (strtoupper($data['transaction_type']) == "D") {
                                $data['debit_amount'] = $data['transaction_amount'];
                                $data['credit_amount'] = 0;
                            } else if (strtoupper($data['transaction_type']) == "C") {
                                $data['credit_amount'] = $data['transaction_amount'];
                                $data['debit_amount'] = 0;
                            } else {
                                $data['credit_amount'] = 0;
                                $data['debit_amount'] = 0;
                            }
                            unset($data['transaction_amount']);
                            unset($data['transaction_type']);
                            $insertData[] = $data;
                        } else if (isset($data['credit_amount'])) {
                            $data['debit_amount'] = 0;
                            $insertData[] = $data;
                        } else if (isset($data['debit_amount'])) {
                            $data['credit_amount'] = 0;
                            $insertData[] = $data;
                        }
                    }
                }
                //save data of current file to the database
                foreach ($insertData AS $data) {
                    if ($statementDate == $data['transaction_date']) {
                        $resultData[$count] = $data;
                        $count++;
                    }
                }
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        }
        if ($count == 0) {
            throw new Exception("File data can't be uploaded as entered <b>Statement Date</b> doesn't match with <b>Transaction Date</b> in uploaded file.");
        }
        return $resultData;
    }

    public function uploadBankStatementData($data) {
        try {
            $this->setSource("bank_statements");
            $data = json_decode(gzuncompress(base64_decode($data)), true);
//pr($data);
            foreach ($data as $record) {
//                try {
                $this->create();
                if ($record['bankid'] == 2) {
                    $record['cheque_no'] = isset($record['transaction_id']) ? $record['transaction_id'] : '';
                }
                $this->save($record);
//                } catch (Exception $e) {
//                    CakeLog::write("BankStatemnentLog", $e->getMessage() . "  data:" . var_export($record, true));
//                }
            }
        } catch (Exception $ex) {
            throw new Exception("Record Can't be uploaded please try again" . $ex->getMessage());
        }
    }

}
