<!DOCTYPE html>
<html>
<title>CV-{{ $teacher->id }}-{{ $teacher->latin_name }}</title>
<meta charset="UTF-8">
<head>
    <style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }
    
    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }
    
    tr:nth-child(even) {
    background-color: #dddddd;
    }

    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        border-radius: 5px;
        }
        .fix-button {
            position: fixed;
            left: 0;
            right: 200;
            top: 0;
            background: rgba(0, 0, 0, .2);
            overflow-x: auto;
            padding: 10px;
            white-space: nowrap;
        }
    </style>
    </head>
<body class="w3-light-grey">
    <!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
      <div id="dvContents" style="visibility: visible;">
        <div class="left">
            {{-- <img alt="" src="images/ASPSnippets.png" /> --}}
        </div>
        <div style="text-align: center; width:100%; background-color:white;">
        <img src="{{asset('public\uploads\header_page.png')}}" alt="">
            <h3 style="font-family: Hanuman; font-size:30px;" class="label">ប្រវត្តិរូបសង្ខេប​</h3>
        </div>
        {{-- <div class="clear">
        </div>
        <hr /> --}}
        <!-- <div class="contents"> -->
            <!-- Page Container -->
            <div class="w3-content w3-margin-top">               

                <!-- The Grid -->
                <div class="w3-row-padding">
      
                    <!-- Left Column -->
                    <div class="w3-third">        
                        <div class="w3-white w3-text-grey w3-card-4">                       

                            <div class="w3-display-container">
                            <img style="width:100%;" src="{{asset('public/uploads/images')}}/{{$teacher->user->image}}" style="width:100%" alt="Avatar">
                                <div class="w3-display-bottomleft w3-container w3-text-black">
                                    {{-- <h2 style="font-family: Hanuman; padding:10px;">{{ $teacher->name }}<span style="font-family:'Times New Roman', Times, serif; font-size: 18px; ">{{ $teacher->latin_name }}</span></h2> --}}
                                    
                                </div>
                            </div>

                            <div class="w3-container" style="padding-left:10px;">
                                <p style="font-family: Hanuman; font-size:18px; "><i class="fa fa-user fa-fw w3-margin-right w3-large w3-text-teal"></i>{{ $teacher->name }} {{ $teacher->latin_name }}</p>
                                    <p style="font-family: Hanuman;"><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>{{ $teacher->designation }}</p>
                                    <p style="font-family: Hanuman;"><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>{{ $teacher->address }}</p>
                                    <p style="font-family: Hanuman;"><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>{{ $teacher->user->email }}</p>
                                    <p style="font-family: Hanuman;"><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>{{ $teacher->phone }}</p>
                                    <hr>
                
                                    <p class="w3-large" style="font-family:Hanuman; font-size:20px;"><b><i class="fa fa-cogs fa-fw w3-margin-right w3-text-teal"></i>{{_lang('Skills')}}</b></p>
                                       
                                        @foreach ($skills as $sk)
                            <p style="font-family: 'Khmer OS Battambang';" title="{{$sk->description}}"><span class="fa fa-plus"></span> {{$sk->skill}} (<span style="text-size-adjust: 16px; color:blue;">{{$sk->mention}}</span>)</p>  

                                        @endforeach
                                    <br>
                
                                    <p style="font-family:Hanuman; font-size:20px;" class="w3-large w3-text-theme"><b><i class="fa fa-language fa-fw w3-margin-right w3-text-teal"></i>{{_lang('Foreign languages')}}</b></p>
                                    @foreach ($speaks as $sp)
                                        <p style="font-family: 'Khmer OS Battambang';" title="{{$sp->description}}"><span class="fa fa-plus"></span> {{$sp->languages}} (<span style="text-size-adjust: 16px; color:blue;">{{$sp->mention}}</span>)</p>  
                                    @endforeach

                                    <br>
                            </div>
                        </div><br>
    
                    <!-- End Left Column -->
                    </div>   
               
                    <!-- Right Column -->
                    <div class="w3-twothird">
        
                    <div class="w3-container w3-card w3-white w3-margin-bottom">
                        <h3 class="w3-text-grey w3-padding-16" style="font-family: 'Hanuman', Courier, monospace"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>{{_lang("Work Experiences")}}</h3>
                       
                        @foreach ($teacher_works as $teacherW)
                            <div class="w3-container">                                
                                <h5 style="font-family: 'Khmer OS Battambang';" class="w3-opacity"><b>{{$teacherW->position}}</b> <span style="color:slategrey;">{{$teacherW->company}}</span></h5>
                                <?php 
                                    // $fd = date('d-m-Y', strtotime($teacherW->start_date));
                                    $fd = date('M Y', strtotime($teacherW->start_date));
                                    $td = date('M Y', strtotime($teacherW->end_date));
                                        ?>
                                    <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>{{$fd}} - {{$td}}</h6>
                                    <p style="font-family: 'Khmer OS Battambang';">@isset($teacherW->description)
                                    {{$teacherW->description}}
                                    @endisset</p><br>
                            </div>                            
                        @endforeach                       
                        
                    </div>
    
                    <div class="w3-container w3-card w3-white">
                        {{-- <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Education</h2> --}}
                        <h3 class="w3-text-grey w3-padding-16" style="font-family: 'Hanuman', Courier, monospace"><i class="fa fa-certificate fa-fw w3-margin-right w3-xlarge w3-text-teal"></i>{{_lang("Education")}}</h3>
                       
                        @foreach ($teacher_qualifications as $teacherQ)
                            <div class="w3-container">
                                <h5 class="w3-opacity" style="font-family: 'Khmer OS Battambang';"><b> <span class="fa fa-graduation-cap"></span> {{$teacherQ->certificate}} {{$teacherQ->major}}</b></h5>
                                <h6 style="font-family: Hanuman;" class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>{{$teacherQ->start_date}} - {{$teacherQ->end_date}}</h6>
                                <p style="font-family: Hanuman;">{{$teacherQ->degree}} {{_lang('From School')}} <strong>{{$teacherQ->school}}</strong></p><br>
                            </div>
                        @endforeach

                    </div>    
                    <!-- End Right Column -->
                    </div>
        
                <!-- End Grid -->
                </div>      
                <!-- End Page Container -->
                </div>
        <!-- </div> -->
      </div>
   
    <br />
    {{-- <hr> --}}
    <div id="btnBack" class="fix-button" style="text-align: center; font-family:Hanuman;">
    <a class="button"  href="{{route('teachers.index')}}">{{_lang('Exit')}}</a>  <input type="button" id="btnPrint" value="{{_lang('Print')}} CV" />          
    </div>
    <br>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("#btnPrint").hide();
        $("#btnBack").hide();
        window.onload = function() { window.print(); }
        
        $(function() {
            $("#btnPrint").click(function () {               
                
                var contents = $("#dvContents").html();
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({ "position": "absolute", "top": "-1000000px","width":"2480px","hieght":"3508px" });
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.
                frameDoc.document.write('<html><head><title>Print CV</title>');
                frameDoc.document.write('</head><body>');
                //Append the external CSS file.
                // frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
                frameDoc.document.write('<link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet" type="text/css" />');
                // https://www.w3schools.com/w3css/4/w3.css
                frameDoc.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">')
                //Append the DIV contents.
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    // window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 500);
            });
        });
    </script>
</body>
</html>
