<?php
error_reporting(0);
include_once("config.php");

include_once('classes/securityHelper.php');
$database = new Database();
$conn = $database->getConnection();

if (!isset($_SERVER['HTTP_REFERER'])) {
    // redirect them to your desired location
    header('location:../error.php');
    exit;
}
include_once("session_timeout.php");
?>

<link rel="stylesheet" href="css/fulldetail.css" />

<style type="text/css" media="print">
    body {
        visibility: hidden;
        display: none
    }
</style>
<style>
    .custom-sticky-back-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        /* Position on the right side */
        z-index: 1000;
        background-color: #007bff;
        /* Bootstrap primary color */
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        font-size: 16px;
    }

    .custom-sticky-back-btn:hover {
        background-color: #0056b3;
        /* Darker primary color for hover */
    }
</style>

</head>

<body>
    <?php
    // Sanitize and validate ID to prevent SQL injection and ModSecurity issues
    $id = SecurityHelper::sanitizeId($_GET['id'] ?? null);
    if (!$id) {
      die("Invalid form ID");
    }
    
    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM forms WHERE id=?");
    if ($stmt) {
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
    } else {
      die("Database error");
    }
   
    ?>

    <?php

    include_once('header.php');
 
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->

        <?php
        if ($utype == 'subadmin') {
            include_once('subadminsidebar.php');
        } else {
            include_once('sidebar.php');
        }
        ?>

        <table class="bordered" style="font-family: verdana" !important;>
            <thead>

                <tr>
                    <th>#</th>
                    <th style="width: 100px;">FIELDS</th>
                    <th>DATA</th>
                </tr>
            </thead>
            <tr>
                <td>1</td>
                <td>Form No</td>
                <td><?php echo $row['formno'];  ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Record No</td>
                <td><?php echo $row['record_no'];  ?></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Invoice No</td>
                <td><?php echo $row['invoice_no'];  ?></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Date of Purchase</td>
                <td><?php echo $row['demoDate'];  ?></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Customer Id</td>
                <td><?php echo $row['customer_id'];  ?></td>
            </tr>
            <tr>
                <td>6</td>
                <td>File No</td>

                <td><?php echo $row['fileno'];  ?></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Policy Holder Name</td>
                <td><?php echo $row['ph_name'];  ?></td>
            </tr>
            <tr>

                <td>8</td>
                <td>policy Holder Address</td>
                <td><?php echo $row['ph_address'];  ?></td>
            </tr>
            <tr>
                <td>9</td>
                <td>Policy Holder City</td>
                <td><?php echo $row['ph_city'];  ?></td>
            </tr>
            <tr>
                <td>10</td>
                <td>Policy Holder State</td>
                <td><?php echo $row['ph_state'];  ?></td>
            </tr>
            <tr>
                <td>11</td>
                <td>Policy Holder Zip</td>
                <td><?php echo $row['ph_zip'];  ?></td>
            </tr>
            <tr>
                <td>12</td>
                <td>Policy Holder Phone</td>
                <td><?php echo $row['ph_phone'];  ?></td>
            </tr>
            <tr>
                <td>13</td>
                <td>PH Email</td>
                <td><?php echo $row['ph_email'];  ?></td>
            </tr>
            <tr>
                <td>14</td>
                <td>PH DOB </td>
                <td><?php echo $row['ph_dob'];  ?></td>
            </tr>
            <tr>
                <td>15</td>
                <td>Education</td>
                <td><?php echo $row['education'];  ?></td>
            </tr>

            <tr>
                <td>16</td>
                <td>Nominee Name</td>
                <td><?php echo $row['nominee_name'];  ?></td>
            </tr>
            <tr>
                <td>17</td>
                <td>Nominee Address</td>
                <td><?php echo $row['nominee_address'];  ?></td>
            </tr>
            <tr>
                <td>18</td>
                <td>Nominee City</td>
                <td><?php echo $row['nominee_city'];  ?></td>
            </tr>
            <tr>
                <td>19</td>
                <td>Nominee State</td>
                <td><?php echo $row['nominee_state'];  ?></td>
            </tr>
            <tr>
                <td>20</td>
                <td>Nominee Zip</td>
                <td><?php echo $row['nominee_zip'];  ?></td>
            </tr>
            <tr>
                <td>21</td>
                <td>Relation With Nominee</td>
                <td><?php echo $row['relation_with_nominee'];  ?></td>
            </tr>
            <tr>
                <td>22</td>
                <td>Chest</td>
                <td><?php echo $row['chest'];  ?></td>
            </tr>
            <tr>
                <td>23</td>
                <td>Height</td>
                <td><?php echo $row['height'];  ?></td>
            </tr>
            <tr>
                <td>24</td>
                <td>Weight</td>
                <td><?php echo $row['weight'];  ?></td>
            </tr>

            <td>25</td>
            <td>Blood Group</td>
            <td><?php echo $row['blood_group'];  ?></td>
            </tr>
            <tr>
                <td>26</td>
                <td>Policy No</td>
                <td><?php echo $row['policyno'];  ?></td>
            </tr>
            <tr>
                <td>27</td>
                <td>Reference No</td>
                <td><?php echo $row['referenceno'];  ?></td>
            </tr>
            <tr>
                <td>28</td>
                <td>Agent Name</td>
                <td><?php echo $row['agentname'];  ?></td>
            </tr>
            <tr>
                <td>29</td>
                <td>Agent Address</td>
                <td><?php echo $row['agent_address'];  ?></td>
            </tr>
            <tr>
                <td>30</td>
                <td>Agent City</td>
                <td><?php echo $row['agent_city'];  ?></td>
            </tr>
            <tr>
                <td>31</td>
                <td>Agent State</td>
                <td><?php echo $row['agent_state'];  ?></td>
            </tr>
            <tr>
                <td>32</td>
                <td>Agent Zip Code</td>
                <td><?php echo $row['agent_zipcode'];  ?></td>
            </tr>
            <tr>
                <td>33</td>
                <td>Agent Code</td>
                <td><?php echo $row['agent_code'];  ?></td>
            </tr>
            <tr>
                <td>34</td>
                <td>Agent Licence No</td>
                <td><?php echo $row['agent_licenceno'];  ?></td>
            </tr>

            <tr>
                <td>35</td>
                <td>Plan Name</td>
                <td><?php echo $row['plane_name'];  ?></td>
            </tr>
            <tr>
                <td>36</td>
                <td>Plan Code</td>
                <td><?php echo $row['plan_code'];  ?></td>
            </tr>
            <tr>
                <td>37</td>
                <td>Sum Of Insured</td>
                <td><?php echo $row['soi'];  ?></td>
            </tr>
            <tr>
                <td>38</td>
                <td>Period Of Insurance</td>
                <td><?php echo $row['poi'];  ?></td>
            </tr>
            <tr>
                <td>39</td>
                <td>1.Does the life to be insured consume Alcohol/cigarettes/bidis or tobacco in any form?</td>
                <td><?php echo $row['chek1'];  ?></td>
            </tr>
            <tr>
                <td>40</td>
                <td>2. Is the life to be insured currently taking any medication or drug?</td>
                <td><?php echo $row['chek2'];  ?></td>
            </tr>
            <tr>
                <td>41</td>
                <td colspan="2">3. Has the life to be insured ever suffered or is suffering from </td>

            </tr>
            <tr>
                <td></td>
                <td>i) Hypertension/high blood pressure </td>
                <td><?php echo $row['chek3'];  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>ii) Diabetes or raised blood sugar</td>
                <td><?php echo $row['chek4'];  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>iii) Cardiovascular disease, Palpitations, Heart attack, stroke, chest pain</td>
                <td><?php echo $row['chek5'];  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>iv) Genitourinary diseases e.g. Kidney disorder, Bladder disorder, Urine abnormality, renal stones or genital organ disorder</td>
                <td><?php echo $row['chek6'];  ?></td>
            </tr>

            <tr>
                <td>42</td>
                <td>4.Has the life to be insured ever been tested positive for HIV / AIDS, hepatitis B or C or any sexually transmitted disease?</td>
                <td><?php echo $row['chek7'];  ?></td>
            </tr>
            <tr>
                <td>43</td>
                <td>5.Is the life to be insured currently covered under any health insurance policy with any other company?</td>
                <td><?php echo $row['chek8'];  ?></td>
            </tr>
            <tr>
                <td>44</td>
                <td>6.Has the life to be insured ever been involved or is planning to pursue any?</td>
                <td><?php echo $row['chek9'];  ?></td>
            </tr>
            <tr>
                <td>45</td>
                <td>7.Does the life to be insured wear glasses?</td>
                <td><?php echo $row['chek10'];  ?></td>
            </tr>
            <tr>
                <td>46</td>
                <td>Payment Option</td>
                <td><?php echo $row['payment_option'];  ?></td>
            </tr>
            <tr>
                <td>47</td>
                <td>Premium</td>
                <td><?php echo $row['premium'];  ?></td>
            </tr>
            <tr>
                <td>48</td>
                <td>Discount</td>
                <td><?php echo $row['discount'];  ?></td>
            </tr>
            <tr>
                <td>49</td>
                <td>Total Amount</td>
                <td><?php echo $row['total_amount'];  ?></td>
            </tr>
            <tr>
                <td>50</td>
                <td>Card Type</td>
                <td><?php echo $row['card_type'];  ?></td>
            </tr>
            <tr>
                <td>51</td>
                <td>Card No</td>
                <td><?php echo $row['card_no'];  ?></td>
            </tr>
            <tr>
                <td>52</td>
                <td>Expiry Date</td>
                <td><?php echo $row['expiry_date'];  ?></td>
            </tr>
            <tr>
                <td>53</td>
                <td>Card Holder Name</td>
                <td><?php echo $row['card_holder_name'];  ?></td>
            </tr>
            <tr>
                <td>54</td>
                <td>Transaction ID</td>
                <td><?php echo $row['transactionid'];  ?></td>
            </tr>
            <tr>
                <td>55</td>
                <td>Remark</td>
                <td><?php echo $row['remark'];  ?></td>
            </tr>
            <tr>
                <td>56</td>
                <td>Submit Date</td>
                <td><?php echo $row['post_datetime'];  ?></td>
            </tr>
            <tr>
                <td>57</td>
                <td>Update Date</td>
                <td><?php echo $row['update_datetime'];  ?></td>
            </tr>

        </table>
        <!-- Sticky Back Button -->

        <button class="custom-sticky-back-btn" onclick="goBack()">Go Back</button>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        <script src="vendors/base/vendor.bundle.base.js"></script>
        <!-- endinject -->
        <!-- inject:js -->
        <script src="js/off-canvas.js"></script>
        <script src="js/hoverable-collapse.js"></script>
        <script src="js/template.js"></script>
        <script src="js/todolist.js"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="js/file-upload.js"></script>
</body>

</html>