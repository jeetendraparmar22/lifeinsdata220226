<?php
include_once('config.php');

class FormSubmission
{
    private $conn;
    private $utype;
    private $id;
    private $ename;
    private $utypeFromDb;

    public function __construct($dbConnection, $sessionData)
    {
        $this->conn = $dbConnection;
        $this->utype = $sessionData['utype'];
        $this->id = $sessionData['id'];
        $this->ename = $sessionData['empname'];

        // Fetch user type from the database to update based on user type
        $this->utypeFromDb = $this->getUserType();
    }

    public function getUserType()
    {
        if ($this->utype == 'subadmin') {
            $selqq = mysqli_query($this->conn, "SELECT * FROM subadmin WHERE id='$this->id'");
            $rows = mysqli_fetch_array($selqq);
            return $rows['utype'];
        } elseif ($this->utype == 'employee') {
            $selqq = mysqli_query($this->conn, "SELECT * FROM employeedetail WHERE id='$this->id'");
            $rows = mysqli_fetch_array($selqq);
            return $rows['utype'];
        }

        return $this->utype;
    }

    public function updateEmployeeLoginFlag()
    {
        if ($this->utype == 'employee') {
            $flagupdate = "UPDATE `employeedetail` SET flag ='0', last_action_time = NOW() WHERE id=" . $this->id;
            mysqli_query($this->conn, $flagupdate);
        }
    }

    public function saveForm($postData)
    {
        $data = $this->sanitizeData($postData);

        // Check if formno and eid exist
        $checkSql = "SELECT COUNT(*) as count FROM forms WHERE record_no = '{$data['record_no']}' AND eid = '{$data['eid']}'";
        $result = mysqli_query($this->conn, $checkSql);
        $row = mysqli_fetch_assoc($result);

        if ($row['count'] > 0) {
            echo '<script language="javascript">alert("Form with this Record Number already saved.");</script>';
            return;
        }
        $sql = "INSERT INTO forms (formno, record_no, invoice_no, demoDate, customer_id, fileno, ph_name, ph_address, 
                                  ph_city, ph_state, ph_zip, ph_phone, ph_email, ph_dob, education, nominee_name, 
                                  nominee_address, nominee_city, nominee_state, nominee_zip, relation_with_nominee, 
                                  chest, height, weight, blood_group, policyno, referenceno, agentname, agent_address, 
                                  agent_city, agent_state, agent_zipcode, agent_code, agent_licenceno, plane_name, 
                                  plan_code, soi, poi, chek1, chek2, chek3, chek4, chek5, chek6, chek7, chek8, chek9, 
                                  chek10, payment_option, premium, discount, total_amount, card_type, card_no, 
                                  expiry_date, card_holder_name, transactionid, remark, captcha, post_date, 
                                  post_datetime, eid, ename, usertype) 
                                  VALUES ('{$data['formno']}', '{$data['record_no']}', '{$data['invoice_no']}', 
                                          '{$data['demoDate']}', '{$data['customer_id']}', '{$data['fileno']}', 
                                          '{$data['ph_name']}', '{$data['ph_address']}', '{$data['ph_city']}', 
                                          '{$data['ph_state']}', '{$data['ph_zip']}', '{$data['ph_phone']}', 
                                          '{$data['ph_email']}', '{$data['ph_dob']}', '{$data['education']}', 
                                          '{$data['nominee_name']}', '{$data['nominee_address']}', 
                                          '{$data['nominee_city']}', '{$data['nominee_state']}', 
                                          '{$data['nominee_zip']}', '{$data['relation_with_nominee']}', 
                                          '{$data['chest']}', '{$data['height']}', '{$data['weight']}', 
                                          '{$data['blood_group']}', '{$data['policyno']}', 
                                          '{$data['referenceno']}', '{$data['agentname']}', 
                                          '{$data['agent_address']}', '{$data['agent_city']}', 
                                          '{$data['agent_state']}', '{$data['agent_zipcode']}', 
                                          '{$data['agent_code']}', '{$data['agent_licenceno']}', 
                                          '{$data['plane_name']}', '{$data['plan_code']}', '{$data['soi']}', 
                                          '{$data['poi']}', '{$data['chek1']}', '{$data['chek2']}', 
                                          '{$data['chek3']}', '{$data['chek4']}', '{$data['chek5']}', 
                                          '{$data['chek6']}', '{$data['chek7']}', '{$data['chek8']}', 
                                          '{$data['chek9']}', '{$data['chek10']}', '{$data['payment_option']}', 
                                          '{$data['premium']}', '{$data['discount']}', '{$data['total_amount']}', 
                                          '{$data['card_type']}', '{$data['card_no']}', '{$data['expiry_date']}', 
                                          '{$data['card_holder_name']}', '{$data['transactionid']}', 
                                          '{$data['remark']}', '123', '{$data['post_date']}', 
                                          '{$data['post_datetime']}', '{$data['eid']}', '{$data['ename']}', 
                                          '{$data['utype']}')";

        if (mysqli_query($this->conn, $sql)) {

            // Clear all cookies
            echo '<script language="javascript">alert("Your Form has been saved successfully.");</script>';
        } else {
            echo mysqli_error($this->conn);
        }
    }

    private function sanitizeData($data)
    {
        $sanitizedData = [];
        foreach ($data as $key => $value) {
            $sanitizedData[$key] = mysqli_real_escape_string($this->conn, $value);
        }
        // Use the logged-in user's timezone (dynamically loaded from DB into session at login)
        $tz = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
        $dbTz = new DateTimeZone($tz);
        $sanitizedData['post_date'] = (new DateTime('now', $dbTz))->format('Y-m-d');
        $sanitizedData['post_datetime'] = (new DateTime('now', $dbTz))->format('Y-m-d H:i:s');
        $sanitizedData['eid'] = $this->id;
        $sanitizedData['ename'] = $this->ename;
        $sanitizedData['utype'] = $this->utypeFromDb;

        return $sanitizedData;
    }
}


