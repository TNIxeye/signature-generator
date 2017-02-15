<?php
if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    // print_r($sender);
    $layout = file_get_contents('./layout v0.1.html', FILE_USE_INCLUDE_PATH);
    // print_r($layout);
    // echo '<br />'; 
    // echo '<br />';   
      
    foreach ($sender as $key => $value) {
        $key         = strtoupper($key);
        $start_if    = strpos($layout, '[[IF-' . $key . ']]');
        $end_if      = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length      = strlen('[[ENDIF-' . $key . ']]');
        
        // echo "<h1>" . $key . " " . $value . "</h1>";
        // echo "$start_if :" . $start_if;
        // echo "$end_if :" . $end_if;
        // echo "$length :" . $length;


        if (!empty($value)) {
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
        } elseif (is_numeric($start_if)) {
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=smartsignature.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else: ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Lucas Machado">

        <title>Signature Generator</title>

        <!-- Bootstrap core CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style type="text/css">
            /* Sticky footer styles
            -------------------------------------------------- */

            html,
            body {
                height: 100%;
                font-family: Arial;
                /* The html and body elements cannot have any padding or margin. */
            }

            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by its height */
                margin: 0 auto -60px;
                /* Pad bottom by footer height */
                padding: 0 0 60px;
            }

            /* Set the fixed height of the footer here */
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }


            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */

            #wrap > .container {
                padding: 60px 15px 0;
            }
            .container .credit {
                margin: 20px 0;
            }

            #footer > .container {
                padding-left: 15px;
                padding-right: 15px;
            }
            .btn.btn-primary {
                color: #fff !important;
                background-color: #92278f !important;
            }
            code {
                font-size: 80%;
            }
        </style>

    </head>

    <body>

        <!-- Wrap all page content here -->
        <div id="wrap">

            <!-- Fixed navbar -->
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">
                        SMART's Signature Generator</a>
                    </div>
                </div>
            </div>

            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h1>Simple Signature Generator</h1>
                </div>
                <form class="form-horizontal" role="form" method="post" target="preview" id="form">
                    <div class="form-group">
                        <label for="Name" class="control-label col-xs-2">Name</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" id="Name" name="Sender[name]" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label col-xs-2">Job Title</label>
                        <div class="col-xs-10">
                            <input type="text" class="form-control" id="Name" name="Sender[position]" placeholder="Enter your job title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label col-xs-2">Department</label>
                        <!-- <input type="text" class="form-control" id="Name" name="Sender[department]" placeholder="Enter your name"> -->
                        <div class="col-xs-10">
                            <select class="form-control" id="sel1" id="Name" name="Sender[department]">
                                    <option>Customs Consultant</option>
                                    <option>IT Consultant</option>
                                    <option>Executive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label col-xs-2">Email</label>
                        <div class="input-group col-xs-10">
                          <input type="text" class="form-control" id="Email" name="Sender[email]" placeholder="Enter your email" aria-describedby="basic-addon2">
                          <span class="input-group-addon" id="basic-addon2">@smart-consultant.com</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Mobile" class="control-label col-xs-2">Mobile Phone</label>
                        <div class="input-group col-xs-10">
                            <input type="phone" class="form-control" id="Mobile" name="Sender[mobile]" placeholder="+62 (817) 083-0101">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button id="preview" type="submit" class="btn btn-primary">Preview</button>
                                <button id="download" class="btn btn-default">Download</button>
                                <input type="hidden" name="download" id="will-download" value="">    
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="container">
                <iframe src="about:blank" name="preview" width="100%" height="200"></iframe>
            </div>

        </div>

        <div id="footer">
            <div class="container">
                <p class="text-muted credit">Copyright © 2017 SMART All rights reserved.
</p>
            </div>
        </div>


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $( document ).ready(function() {
            $("#download").bind( "click", function() {
                $('#will-download').val('true');
                $('#form').removeAttr('target').submit();
            });

            $("#preview").bind( "click", function() {
                $('#will-download').val('');
                $('#form').attr('target','preview');
            });

        });
        </script>
    </body>
</html>
<?php endif;