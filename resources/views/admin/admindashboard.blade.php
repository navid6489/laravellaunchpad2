@php
if(Auth::user()->role=='admin')
 {
    $id=Auth::user()->id;
    //$countstud= DB::select("SELECT COUNT(*) as cnt_data from adminrequests where flag=0 and roletype='student'");
    $studentrequests =  DB::select("SELECT * from users where flag='0' and role ='student'");
    $teacherrequests =  DB::select("SELECT * from users where flag='0' and role='teacher'");
 }
@endphp
<h2>Welcome Admin<h2>
    <style>
    
        /*tab styling*/
        body {font-family: Arial;}
        
        /* Style the tab */
        .tab {
          overflow: hidden;
          border: 1px solid #ccc;
          background-color: #f1f1f1;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
          background-color: inherit;
          float: left;
          border: none;
          outline: none;
          cursor: pointer;
          padding: 14px 16px;
          transition: 0.3s;
          font-size: 17px;
          color:black;
        }
        
        /* Change background color of buttons on hover */
        .tab button:hover {
          background-color: #ddd;
        }
        
        /* Create an active/current tablink class */
        .tab button.active {
          background-color: #ccc;
        }
        
        /* Style the tab content */
        .tabcontent {
          display: none;
          padding: 6px 12px;
          
          border-top: none;
        }
    
        .notification {
    background-color: #555;
    color: white;
    text-decoration: none;
    padding: 15px 26px;
    position: relative;
    display: inline-block;
    border-radius: 2px;
    }
    
    .notification:hover {
    background: red;
    }
    
    .notification .badge {
    position: absolute;
    top: -10px;
    right: -10px;
    padding: 5px 10px;
    border-radius: 50%;
    background-color: red;
    color: white;
    margin-top: 10px;
    margin-right: 13px;
    }
        </style>    
    
    
    <div class="tab">
        <button class="tablinks  notification" onclick="openRequests(event, 'Student')">Student <span id="studnotification" class="badge"></span></button>
        <button class="tablinks  notification" onclick="openRequests(event, 'Teachers')">Teachers <span id="teachernotification" class="badge"></span></button>
       
      </div>
      
      <div id="Student" class="tabcontent">
        <h3>Student</h3>
        <table class="table table-bordered table-responsive-lg">
          <tr>
              <th>No</th>
              <th>Name</th>
              <th>email</th>
              <th>role</th>
              <th>Assign Teacher</th>
              
        
        <th style="column-span:2; ">Actions</th>
          </tr>
          
          @foreach ($studentrequests as $studentrequests2)
              <tr>
                  <td>{{$studentrequests2->id}}</td>
                  <td>{{$studentrequests2->name}}</td>
                  <td>{{$studentrequests2->email}}</td>
                  <td>{{$studentrequests2->role}}</td>
                  <td><select class="form-control" id="teacher{{$studentrequests2->id}}"  name="teacher{{$studentrequests2->id}}">

                    <option value="">Select Teacher</option>
                    @foreach ($teacherrequests as $teacherrequests2)
                    <option value="{{$teacherrequests2->name}}">{{$teacherrequests2->name}}</option>
                    @endforeach
                  </select>
                  <td>
                 
                  <td><a type="button" class='btn btn-success'  onclick="studentapprovedata('{{$studentrequests2->id}}','teacher{{$studentrequests2->id}}')">Approve</a></td>
                  <td><a  class='btn btn-primary' href="<?php echo url('/adminstudedit')?>/{{$studentrequests2->id}}" >Edit</a></td>
         
          
                  
              </tr>
          @endforeach
      </table>
      
      </div>
      
      <div id="Teachers" class="tabcontent">
        <h3>Teachers</h3>
        <table class="table table-bordered table-responsive">
          <tr>
              <th>No</th>
              <th>Name</th>
              <th>email</th>
              <th>role</th>
              
        <th>Actions</th>
          </tr>
         
          
          @foreach ($teacherrequests as $teacherrequests2)
              <tr>
                  <td>{{$teacherrequests2->id}}</td>
                  <td>{{$teacherrequests2->name}}</td>
                  <td>{{$teacherrequests2->email}}</td>
                  <td>{{$teacherrequests2->role}}</td>
                  
                 
                  <td><a type="button" class='btn btn-success' onclick="teacherapprovedata('{{$teacherrequests2->id}}')">approve</a></td>
                  
                 
         
                  
              </tr>
          @endforeach
      </table> 
     
      </div>
    
     
      <script>
        function openRequests(evt, recordtype) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(recordtype).style.display = "block";
          evt.currentTarget.className += " active";
        }
        </script>
    <!--teacher related script-->
      <script>
        function teacherapprovedata(id) {
        
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    
    type: "POST",
    url: "<?php echo url('/teacherapprove')?>/"+id,
    data: {id: id},
    
       success: function(result){
      
              //console.log(result);
            if(result==1){
                
              alert("teacher approved Successfully");
              window.location.reload(true);
                }
                else
                {
                 
                  alert("teacher approval Failed");
                }
    }
    
    })
    }
    
    
        </script>
     
    
    
     <!--student related script-->
      <script>
          function studentapprovedata(id,teacher) {
            var assignedteacher=  $('#'+teacher).val();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    
      type: "POST",
      url: "<?php echo url('/studapprove')?>/"+id,
      data: {id: id, assignedteacher: assignedteacher},
    
         success: function(result){
        
                //console.log(result);
              if(result==1){
                  
                alert("student approved Successfully");
                window.location.reload(true);
                  }
                  else
                  {
                   
                    alert("student approval Failed");
                  }
     }
      
    })
    }
    

          </script>