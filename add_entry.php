<?php
  if (!isset($_SERVER['HTTP_REFERER'])) {
      header('location:index.php');
      exit;
  }
  
  include_once('header.php');
  include_once 'classes/formHandler.php';

  $formSubmission = new FormSubmission($conn, $_SESSION);
  $formSubmission->updateEmployeeLoginFlag();

  if (isset($_POST['submit'])) {
      $formSubmission->saveForm($_POST);
      echo '<script>window.location.href = "add_entry.php";</script>';
  }   
  ?>

<style type="text/css" media="print">
  body {
    visibility: hidden;
    display: none
  }
</style>
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
            <div class="card-body">

              <p class="card-description">

              </p>
              <form class="forms-sample" enctype="multipart/form-data" method="post" action="add_entry.php">
                <div class="form-group">
                  <label for="exampleInputUsername1">Form No</label>
                  <input type="text" class="form-control" placeholder="Enter Form No" name="formno" id="formno" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Record No</label>
                  <input type="text" class="form-control" placeholder="Enter Record No" name="record_no" id="record_no" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Invoice No</label>
                  <input type="text" class="form-control" placeholder="Enter Invoice No" name="invoice_no" id="invoice_no" required autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="exampleInputConfirmPassword1">Date of Purchase</label>
                  <input type="text" class="form-control" id="demoDate" placeholder="MM/DD/YYYY" name="demoDate">
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
                  <input type="text" class="form-control" placeholder="Enter Customer Id" name="customer_id" id="customer_id" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputEmail2" class="col-sm-3 col-form-label">File No</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter File No" name="fileno" id="fileno" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputMobile" class="col-sm-3 col-form-label">Policy Holder Name</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter Policy Holder Name" name="ph_name" id="ph_name" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Policy Holder Address</label>
                <div class="col-sm-9">
                  <textarea class="form-control" id="exampleTextarea1" rows="2" autocomplete="off" name="ph_address" id="ph_address" placeholder="Enter Policy Holder Address"></textarea>

                </div>
              </div>
              <div class="form-group row">
                <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Policy Holder City</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Enter Policy Holder City" name="ph_city" id="ph_city" required autocomplete="off">
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
                <input type="text" class="form-control" placeholder="Enter Policy Holder State" name="ph_state" id="ph_state" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail3">Policy Holder Zip</label>
                <input type="text" class="form-control" placeholder="Enter Policy Holder Zip" name="ph_zip" id="ph_zip" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword4">Policy Holder Phone</label>
                <input type="text" class="form-control" placeholder="Enter Policy Holder Phone" name="ph_phone" id="ph_phone" required autocomplete="off">
              </div>
              <div class="form-group">
                <label for="exampleSelectGender">Policy Holder Email</label>
                <input type="text" class="form-control" placeholder="Policy Holder Email" name="ph_email" id="ph_email" required autocomplete="off">
              </div>

              <div class="form-group">
                <label for="exampleInputCity1">Policy Holder DOB</label>
                <input type="text" class="form-control" name="ph_dob" placeholder="MM/DD/YYYY">
              </div>
              <div class="form-group">
                <label for="exampleTextarea1">Education</label>

                <input type="text" class="form-control" placeholder="Enter Education" name="education" id="education" required autocomplete="off">

              </div>


            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">


              <div class="form-group">
                <label>Nominee Name</label>
                <input type="text" class="form-control form-control-lg" placeholder="Enter Nominee Name" name="nominee_name" id="nominee_name" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nominee Address</label>
                <textarea class="form-control fix-height" id="exampleTextarea" name="nominee_address" id="nominee_address" placeholder="Enter Nominee Address"></textarea>
              </div>
              <div class="form-group">
                <label>Nominee City</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee City" name="nominee_city" id="nominee_city" required autocomplete="off">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">

              <div class="form-group">
                <label for="exampleFormControlSelect1">Nominee State</label>
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee State" name="nominee_state" id="nominee_state" required autocomplete="off">
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
                <input type="text" class="form-control form-control-sm" placeholder="Enter Nominee Zip" name="nominee_zip" id="nominee_zip" required autocomplete="off">
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
                <input type="text" class="form-control form-control-sm" placeholder="Enter Relation With Nominee" name="relation_with_nominee" id="relation_with_nominee" required autocomplete="off">
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
                      <input type="text" class="form-control" placeholder="Enter Chest" name="chest" id="chest" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Height</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Height" name="height" id="height" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Weight</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Weight" name="weight" id="weight" required autocomplete="off" />
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
                      <input class="form-control" type="text" placeholder="Enter Blood Group" name="blood_group" id="blood_group" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Policy No</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Policy No" name="policyno" id="policyno" required autocomplete="off" />
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
                      <input class="form-control" type="text" placeholder="Enter Reference No" name="referenceno" id="referenceno" required autocomplete="off" />

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
                      <input type="text" class="form-control" placeholder="Enter Agent Name" name="agentname" id="agentname" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Address</label>
                    <div class="col-sm-9">
                      <textarea class="form-control fix-height" id="exampleTextarea" name="agent_address" id="agent_address" placeholder="Enter Agent Address"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent City</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent City" name="agent_city" id="agent_city" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent State</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent State" name="agent_state" id="agent_state" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Zip Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent Zip Code" name="agent_zipcode" id="agent_zipcode" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agent Code" name="agent_code" id="agent_code" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Agent Licence No</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Agnet Licence No" name="agent_licenceno" id="agent_licenceno" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Plan Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Plan Name" name="plane_name" id="plane_name" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Plan Code</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Plan Code" name="plan_code" id="plan_code" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sum Of Insured</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Sum Of Insured" name="soi" id="soi" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Period Of Insurance</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Period Of Insurance" name="poi" id="poi" required autocomplete="off" />
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
                            <input type="radio" class="form-check-input" name="chek1" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek1" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek2" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek2" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek3" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek3" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek4" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek4" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek5" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek5" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek6" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek6" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek7" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek7" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek8" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek8" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek9" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek9" id="membershipRadios2" value="No" required>
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
                            <input type="radio" class="form-check-input" name="chek10" id="membershipRadios1" value="Yes" required>
                            Yes
                          </label>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="chek10" id="membershipRadios2" value="No" required>
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
                      <select class="form-control" id="exampleSelect4" name="payment_option" id="payment_option" required>
                        <option value="">-Select Payment Option-</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Cash/Credit Card">Cash/Credit Card</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Premium</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Premium" name="premium" id="premium" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Discount" name="discount" id="discount" required autocomplete="off" />
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
                      <input class="form-control" type="text" placeholder="Enter Total Amount" name="total_amount" id="total_amount" autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card Type</label>
                    <div class="col-sm-9">

                      <select class="form-control" name="card_type">
                        <option value="">-Select Card Type-</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="Diners Club">Diners Club</option>
                        <option value="Discover">Discover</option>
                        <option value="Voyager">Voyager</option>
                        <option value="enRoute">enRoute</option>
                        <option value="American Express">American Express</option>
                        <option value="JCB">JCB</option>
                        <option value="Visa">Visa</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card No</label>
                    <div class="col-sm-9">
                      <input class="form-control" type="text" placeholder="Enter Card No" name="card_no" id="card_no" required autocomplete="off" />

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
                      <input type="text" class="form-control" placeholder="Enter Expiry Date" name="expiry_date" id="expiry_date" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Card Holder Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Card Holder Name" name="card_holder_name" id="card_holder_name" required autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Transaction ID</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Transaction ID" name="transactionid" id="transactionid" required autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Remark</label>
                    <div class="col-sm-9">
                      <textarea class="form-control" id="exampleTextarea" name="remark" rows="3" id="remark"></textarea>
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

              <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
              <input type="reset" class="btn btn-secondary" href="#">


              </form>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->

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