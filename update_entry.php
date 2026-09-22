<?php
if (!isset($_SERVER['HTTP_REFERER'])) {
  header('location:index.php');
  exit;
}
include_once('header.php');
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:../../partials/_sidebar.html -->

  <?php

  include_once('sidebar.php');

  ?>

  <!-- partial -->

  <div class="main-panel">

    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <?php
            include_once('classes/securityHelper.php');
            // Sanitize and validate ID to prevent SQL injection and ModSecurity issues
            $id = SecurityHelper::sanitizeId($_GET['id'] ?? null);
            $arr = null;
            if ($id) {
              // Use prepared statement for security
              $stmt = $conn->prepare("SELECT * FROM forms WHERE id=?");
              if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                  $arr = $result->fetch_assoc();
                }
                $stmt->close();
              }
            }
            ?>
            <?php
            if ($id) {
            ?>
              <div class="card-body">

                <p class="card-description">

                </p>
                <form class="forms-sample" enctype="multipart/form-data" method="post" action="">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Form No</label>
                    <input type="text" class="form-control" placeholder="Enter Form No" name="formno" id="formno" value="<?php echo $arr['formno']; ?>" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Record No</label>
                    <input type="text" class="form-control" placeholder="Enter Record No" name="record_no" id="record_no" value="<?php echo $arr['record_no']; ?>" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Invoice No</label>
                    <input type="text" class="form-control" placeholder="Enter Invoice No" name="invoice_no" id="invoice_no" value="<?php echo $arr['invoice_no']; ?>" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputConfirmPassword1">Date of Purchase</label>
                    <input type="text" class="form-control" id="demoDate" placeholder="MM/DD/YYYY" value="<?php echo $arr['demoDate']; ?>" name="demoDate">
                  </div>



              </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">

              <p class="card-description">

              </p>

              <div class="form-group row">
                <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Customer Id</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter Customer Id" name="customer_id" id="customer_id" value="<?php echo $arr['customer_id']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">File No</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter File No" name="fileno" id="fileno" value="<?php echo $arr['fileno']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Policy Holder Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter Policy Holder Name" name="ph_name" id="ph_name" value="<?php echo $arr['ph_name']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Policy Holder Address</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="exampleTextarea1" rows="2" name="ph_address" id="ph_address"><?php echo $arr['ph_address']; ?></textarea>

                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Policy Holder City</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter Policy Holder City" name="ph_city" id="ph_city" value="<?php echo $arr['ph_city']; ?>" required autocomplete="off">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>
              <p class="card-description">

              </p>

              <div class="form-group">
                <label for="exampleInputName1">Policy Holder State</label>
                <input type="text" class="form-control" placeholder="Enter Policy Holder State" name="ph_state" id="ph_state" value="<?php echo $arr['ph_state']; ?>" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail3">Policy Holder Zip</label>
                <input type="text" class="form-control" placeholder="Enter Policy Holder Zip" name="ph_zip" id="ph_zip" value="<?php echo $arr['ph_zip']; ?>" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword4">Policy Holder Phone</label>
                <input type="text" class="form-control" placeholder="Enter Policy Holder Phone" name="ph_phone" id="ph_phone" value="<?php echo $arr['ph_phone']; ?>" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleSelectGender">Policy Holder Email</label>
                <input type="text" class="form-control" placeholder="Policy Holder Email" name="ph_email" id="ph_email" value="<?php echo $arr['ph_email']; ?>" autocomplete="off">
              </div>

              <div class="form-group">
                <label for="exampleInputCity1">Policy Holder DOB</label>
                <input type="text" class="form-control" name="ph_dob" value="<?php echo $arr['ph_dob']; ?>" placeholder="MM/DD/YYYY">
              </div>
              <div class="form-group">
                <label for="exampleTextarea1">Education</label>

                <input type="text" class="form-control" placeholder="Enter Education" name="education" id="education" value="<?php echo $arr['education']; ?>" required autocomplete="off">

              </div>


            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <div class="form-group">
                <label>Nominee Name</label>
                <input type="text" class="form-control form-control-lg" placeholder="Enter Nominee Name" name="nominee_name" id="nominee_name" value="<?php echo $arr['nominee_name']; ?>" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nominee Address</label>
                <textarea class="form-control fix-height" id="exampleTextarea" name="nominee_address" id="nominee_address"><?php echo $arr['nominee_address']; ?></textarea>
              </div>
              <div class="form-group">
                <label>Nominee City</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee City" name="nominee_city" id="nominee_city" value="<?php echo $arr['nominee_city']; ?>" required autocomplete="off">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">

              <div class="form-group">
                <label for="exampleFormControlSelect1">Nominee State</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee State" name="nominee_state" id="nominee_state" value="<?php echo $arr['nominee_state']; ?>" required autocomplete="off">
                <!--<select class="form-control form-control-lg" id="exampleFormControlSelect1">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>-->
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect2">Nominee Zip</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee Zip" name="nominee_zip" value="<?php echo $arr['nominee_zip']; ?>" id="nominee_zip" required autocomplete="off">
                <!--<select class="form-control" id="exampleFormControlSelect2">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>-->
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect3">Relation With Nominee</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Relation With Nominee" name="relation_with_nominee" value="<?php echo $arr['relation_with_nominee']; ?>" id="relation_with_nominee" required autocomplete="off">
              </div>
            </div>
          </div>
        </div>



        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>

              <p class="card-description">

              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Chest</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Chest" name="chest" id="chest" value="<?php echo $arr['chest']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Height</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Height" name="height" id="height" value="<?php echo $arr['height']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Weight</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Weight" name="weight" id="weight" value="<?php echo $arr['weight']; ?>" required autocomplete="off" />
                    </div>
                    <!--<div class="col-sm-9">
                            <select class="form-control">
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                          </div>-->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Blood Group</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Blood Group" name="blood_group" value="<?php echo $arr['blood_group']; ?>" id="blood_group" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Policy No</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Policy No" name="policyno" id="policyno" value="<?php echo $arr['policyno']; ?>" required autocomplete="off" />
                      <!--<select class="form-control">
                              <option>Category1</option>
                              <option>Category2</option>
                              <option>Category3</option>
                              <option>Category4</option>
                            </select>-->
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Reference No</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Reference No" name="referenceno" id="referenceno" value="<?php echo $arr['referenceno']; ?>" required autocomplete="off" />

                    </div>
                    <!--<div class="col-sm-4">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked>
                                Free
                              </label>
                            </div>
                          </div>-->
                    <!--<div class="col-sm-5">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2">
                                Professional
                              </label>
                            </div>
                          </div>-->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent Name" name="agentname" id="agentname" value="<?php echo $arr['agentname']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Address</label>
                    <div class="col-sm-9">
                      <textarea class="form-control fix-height" id="exampleTextarea" name="agent_address" id="agent_address"><?php echo $arr['agent_address']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent City</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent City" name="agent_city" id="agent_city" value="<?php echo $arr['agent_city']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent State</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent State" name="agent_state" id="agent_state" value="<?php echo $arr['agent_state']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Zip Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent Zip Code" name="agent_zipcode" id="agent_zipcode" value="<?php echo $arr['agent_zipcode']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent Code" name="agent_code" id="agent_code" value="<?php echo $arr['agent_code']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Licence No</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agnet Licence No" name="agent_licenceno" id="agent_licenceno" value="<?php echo $arr['agent_licenceno']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Plan Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Plane Name" name="plane_name" id="plane_name" value="<?php echo $arr['plane_name']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Plan Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Plane Code" name="plan_code" id="plan_code" value="<?php echo $arr['plan_code']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sum Of Insured</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Sum Of Insured" name="soi" id="soi" value="<?php echo $arr['soi']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Period Of Insurance</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Period Of Insurance" name="poi" id="poi" value="<?php echo $arr['poi']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">

                    </div>










                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-description">

                    </p>

                    <div class="form-group">
                      <label for="exampleInputName1">1. &nbsp;Does the life to be insured consume Alcohol/cigarettes/bidis or tobacco in any form?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek1" id="membershipRadios1" value="Yes" <?php if ($arr['chek1'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek1" id="membershipRadios2" value="No" <?php if ($arr['chek1'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">2. &nbsp;Is the life to be insured currently taking any medication or drug?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek2" id="membershipRadios1" value="Yes" <?php if ($arr['chek2'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek2" id="membershipRadios2" value="No" <?php if ($arr['chek2'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">3. &nbsp;Hypertension/high blood pressure.</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek3" id="membershipRadios1" value="Yes" <?php if ($arr['chek3'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek3" id="membershipRadios2" value="No" <?php if ($arr['chek3'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleSelectGender">4.&nbsp;Diabetes or raised blood sugar?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek4" id="membershipRadios1" value="Yes" <?php if ($arr['chek4'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek4" id="membershipRadios2" value="No" <?php if ($arr['chek4'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputCity1">5. &nbsp;Cardiovascular disease, Palpitations, Heart attack, stroke, chest pain?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek5" id="membershipRadios1" value="Yes" <?php if ($arr['chek5'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek5" id="membershipRadios2" value="No" <?php if ($arr['chek5'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">6.&nbsp;Genitourinary diseases e.g. Kidney disorder, Bladder disorder, Urine abnormality, renal stones or genital organ disorder?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek6" id="membershipRadios1" value="Yes" <?php if ($arr['chek6'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek6" id="membershipRadios2" value="No" <?php if ($arr['chek6'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="exampleTextarea1">7.&nbsp;Has the life to be insured ever been tested positive for HIV / AIDS, hepatitis B or C or any sexually transmitted disease?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek7" id="membershipRadios1" value="Yes" <?php if ($arr['chek7'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek7" id="membershipRadios2" value="No" <?php if ($arr['chek7'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">8.&nbsp;Is the life to be insured currently covered under any health insurance policy with any other company?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek8" id="membershipRadios1" value="Yes" <?php if ($arr['chek8'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek8" id="membershipRadios2" value="No" <?php if ($arr['chek8'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">9.&nbsp;Has the life to be insured ever been involved or is planning to pursue any?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek9" id="membershipRadios1" value="Yes" <?php if ($arr['chek9'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek9" id="membershipRadios2" value="No" <?php if ($arr['chek9'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">10.&nbsp;Does the life to be insured wear glasses?</label>
                      <div class="col-sm-4">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek10" id="membershipRadios1" value="Yes" <?php if ($arr['chek10'] == 'Yes') echo 'checked="checked"'; ?>>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek10" id="membershipRadios2" value="No" <?php if ($arr['chek10'] == 'No') echo 'checked="checked"'; ?>>
                            No
                          </label>
                        </div>
                      </div>
                    </div>




                  </div>
                </div>
              </div>





            </div>
          </div>
        </div>


        <div class="col-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title"></h4>

              <p class="card-description">

              </p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Payment Option</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="exampleSelect4" name="payment_option" id="payment_option" value="<?php echo $arr['payment_option']; ?>">
                        <option value="Credit Card" <?php if ($arr['payment_option'] == "Credit Card") echo 'selected="selected"'; ?>>Credit Card</option>
                        <option value="Cash/Credit Card" <?php if ($arr['payment_option'] == "Cash/Credit Card") echo 'selected="selected"'; ?>>Cash/Credit Card</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Premium</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Premium" name="premium" id="premium" value="<?php echo $arr['premium']; ?>" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Discount" name="discount" id="discount" value="<?php echo $arr['discount']; ?>" required autocomplete="off" />
                    </div>
                    <!--<div class="col-sm-9">
                            <select class="form-control">
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                          </div>-->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Total Amount</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Total Amount" name="total_amount" id="total_amount" value="<?php echo $arr['total_amount']; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card Type</label>
                    <div class="col-sm-9">

                      <select class="form-control" id="exampleSelect3" name="card_type" id="card_type" value="<?php echo $arr['card_type']; ?>">
                        <option value="MasterCard" <?php if ($arr['card_type'] == "MasterCard") echo 'selected="selected"'; ?>>MasterCard</option>
                        <option value="Diners Club" <?php if ($arr['card_type'] == "Diners Club") echo 'selected="selected"'; ?>>Diners Club</option>
                        <option value="Discover" <?php if ($arr['card_type'] == "Discover") echo 'selected="selected"'; ?>>Discover</option>
                        <option value="Voyager" <?php if ($arr['card_type'] == "Voyager") echo 'selected="selected"'; ?>>Voyager</option>
                        <option value="enRoute" <?php if ($arr['card_type'] == "enRoute") echo 'selected="selected"'; ?>>enRoute</option>
                        <option value="American Express" <?php if ($arr['card_type'] == "American Express") echo 'selected="selected"'; ?>>American Express</option>
                        <option value="JCB" <?php if ($arr['card_type'] == "JCB") echo 'selected="selected"'; ?>>JCB</option>
                        <option value="Visa" <?php if ($arr['card_type'] == "Visa") echo 'selected="selected"'; ?>>Visa</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card No</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Card No" name="card_no" id="card_no" value="<?php echo $arr['card_no']; ?>" required autocomplete="off" />

                    </div>
                    <!--<div class="col-sm-4">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios1" value="" checked>
                                Free
                              </label>
                            </div>
                          </div>-->
                    <!--<div class="col-sm-5">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="option2">
                                Professional
                              </label>
                            </div>
                          </div>-->
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Expiry Date</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Expity Date" name="expiry_date" id="expiry_date" value="<?php echo $arr['expiry_date']; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card Holder Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Card Holder Name" name="card_holder_name" value="<?php echo $arr['card_holder_name']; ?>" id="card_holder_name" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Transaction ID</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Transaction ID" name="transactionid" value="<?php echo $arr['transactionid']; ?>" id="transactionid" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Remark</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="exampleTextarea" name="remark" rows="3" id="remark"><?php echo $arr['remark']; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>





              <div class="row">



                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">

                    </div>
                  </div>
                </div>
              </div>

              <button type="submit" class="btn btn-primary mr-2" name="update">Update</button>



              </form>
            <?php } ?>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php
          include_once('config.php');
          // Sanitize and validate ID to prevent SQL injection and ModSecurity issues
          $id = SecurityHelper::sanitizeId($_GET['id'] ?? null);
          if (!$id) {
            die("Invalid form ID");
          }



          if (isset($_POST['update'])) {

            // Use the logged-in user's timezone (dynamically loaded from DB into session at login)
            $tz = !empty($_SESSION['timezone']) ? $_SESSION['timezone'] : 'Asia/Kolkata';
            $update_datetime = (new DateTime('now', new DateTimeZone($tz)))->format('Y-m-d H:i:s');
            $formno = mysqli_real_escape_string($conn, $_POST['formno']);
            $record_no = mysqli_real_escape_string($conn, $_POST['record_no']);



            $invoice_no = mysqli_real_escape_string($conn, $_POST['invoice_no']);

            $demoDate = mysqli_real_escape_string($conn, $_POST['demoDate']);
            //$demoDate=date("Y-d-m", strtotime($demoDate1));
            $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
            $fileno = mysqli_real_escape_string($conn, $_POST['fileno']);
            $ph_name = mysqli_real_escape_string($conn, $_POST['ph_name']);
            $ph_address = mysqli_real_escape_string($conn, $_POST['ph_address']);
            $ph_city = mysqli_real_escape_string($conn, $_POST['ph_city']);
            $ph_state = mysqli_real_escape_string($conn, $_POST['ph_state']);
            $ph_zip = mysqli_real_escape_string($conn, $_POST['ph_zip']);
            $ph_phone = mysqli_real_escape_string($conn, $_POST['ph_phone']);
            $ph_email = mysqli_real_escape_string($conn, $_POST['ph_email']);
            $ph_dob = mysqli_real_escape_string($conn, $_POST['ph_dob']);
            $education = mysqli_real_escape_string($conn, $_POST['education']);
            $nominee_name = mysqli_real_escape_string($conn, $_POST['nominee_name']);
            $nominee_address = mysqli_real_escape_string($conn, $_POST['nominee_address']);
            $nominee_city = mysqli_real_escape_string($conn, $_POST['nominee_city']);
            $nominee_state = mysqli_real_escape_string($conn, $_POST['nominee_state']);
            $nominee_zip = mysqli_real_escape_string($conn, $_POST['nominee_zip']);
            $relation_with_nominee = mysqli_real_escape_string($conn, $_POST['relation_with_nominee']);
            $chest = mysqli_real_escape_string($conn, $_POST['chest']);
            $height = mysqli_real_escape_string($conn, $_POST['height']);
            $weight = mysqli_real_escape_string($conn, $_POST['weight']);
            $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
            $policyno = mysqli_real_escape_string($conn, $_POST['policyno']);
            $referenceno = mysqli_real_escape_string($conn, $_POST['referenceno']);
            $agentname = mysqli_real_escape_string($conn, $_POST['agentname']);
            $agent_address = mysqli_real_escape_string($conn, $_POST['agent_address']);
            $agent_city = mysqli_real_escape_string($conn, $_POST['agent_city']);
            $agent_state = mysqli_real_escape_string($conn, $_POST['agent_state']);
            $agent_zipcode = mysqli_real_escape_string($conn, $_POST['agent_zipcode']);
            $agent_code = mysqli_real_escape_string($conn, $_POST['agent_code']);
            $agent_licenceno = mysqli_real_escape_string($conn, $_POST['agent_licenceno']);
            $plane_name = mysqli_real_escape_string($conn, $_POST['plane_name']);
            $plan_code = mysqli_real_escape_string($conn, $_POST['plan_code']);
            $soi = mysqli_real_escape_string($conn, $_POST['soi']);
            $poi = mysqli_real_escape_string($conn, $_POST['poi']);
            $chek1 = mysqli_real_escape_string($conn, $_POST['chek1']);
            $chek2 = mysqli_real_escape_string($conn, $_POST['chek2']);
            $chek3 = mysqli_real_escape_string($conn, $_POST['chek3']);
            $chek4 = mysqli_real_escape_string($conn, $_POST['chek4']);
            $chek5 = mysqli_real_escape_string($conn, $_POST['chek5']);
            $chek6 = mysqli_real_escape_string($conn, $_POST['chek6']);
            $chek7 = mysqli_real_escape_string($conn, $_POST['chek7']);
            $chek8 = mysqli_real_escape_string($conn, $_POST['chek8']);
            $chek9 = mysqli_real_escape_string($conn, $_POST['chek9']);
            $chek10 = mysqli_real_escape_string($conn, $_POST['chek10']);
            $payment_option = mysqli_real_escape_string($conn, $_POST['payment_option']);
            $premium = mysqli_real_escape_string($conn, $_POST['premium']);
            $discount = mysqli_real_escape_string($conn, $_POST['discount']);
            $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
            $card_type = mysqli_real_escape_string($conn, $_POST['card_type']);
            $card_no = mysqli_real_escape_string($conn, $_POST['card_no']);
            $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
            $card_holder_name = mysqli_real_escape_string($conn, $_POST['card_holder_name']);
            $transactionid = mysqli_real_escape_string($conn, $_POST['transactionid']);
            $remark = mysqli_real_escape_string($conn, $_POST['remark']);
            //$captcha = $_POST['captcha'];

            $update = mysqli_query($conn, "UPDATE forms SET formno ='$formno',
				record_no ='$record_no',
				invoice_no ='$invoice_no',
				demoDate ='$demoDate',
				customer_id ='$customer_id',
				fileno='$fileno',
				ph_name='$ph_name',
				ph_address='$ph_address',
				ph_city='$ph_city',
				ph_state='$ph_state',
				ph_zip='$ph_zip',
				ph_phone='$ph_phone',
				ph_email='$ph_email',
				ph_dob='$ph_dob',
				education='$education',
				nominee_name='$nominee_name',
				nominee_address='$nominee_address',
				nominee_city='$nominee_city',
				nominee_state='$nominee_state',
				nominee_zip='$nominee_zip',
				relation_with_nominee='$relation_with_nominee',
				chest='$chest',
				height='$height',
				weight='$weight',
				blood_group='$blood_group',
				policyno='$policyno',
				referenceno='$referenceno',
				agentname='$agentname',
				agent_address='$agent_address',
				agent_city='$agent_city',
				agent_state='$agent_state',
				agent_zipcode='$agent_zipcode',
				agent_code='$agent_code',
				agent_licenceno='$agent_licenceno',
				plane_name='$plane_name',
				plan_code='$plan_code',
				soi='$soi',
				poi='$poi',
				chek1='$chek1',
				chek2='$chek2',
				chek3='$chek3',
				chek4='$chek4',
				chek5='$chek5',
				chek6='$chek6',
				chek7='$chek7',
				chek8='$chek8',
				chek9='$chek9',
				chek10='$chek10',
				payment_option='$payment_option',
				premium='$premium',
				discount='$discount',
				total_amount='$total_amount',
				card_type='$card_type',
				card_no='$card_no',
				expiry_date='$expiry_date',
				card_holder_name='$card_holder_name',
				transactionid='$transactionid',
				update_datetime ='$update_datetime',
				remark='$remark' WHERE id='$id'
				");
            echo "<script>alert('Form has been updated successfully.');</script>";


            echo "<script>window.location.href='entrylist.php';</script>";
          }
          ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
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
    <!-- End custom js for this page-->
    </body>

    </html>