 $(document).ready(function () {
          
          $('#forma').on('submit', function(e){
              e.preventDefault();
               $("#formaWrapper div.alert").remove();
                var data = new FormData(this);
               $.ajax({
                  type: $(this).attr('method'),
                  url: $(this).attr('action'),
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function (response) {
                      $("#forma *").removeClass('is-invalid');
                      $("span.invalid-feedback").remove();
                     if (response.status == 400) {
                         $.each(response.errors, function (field, arrayOfErrors) {
                             
                                $('#' + field).after(
                                    `<span class="invalid-feedback" role="alert">
                                        <strong>${arrayOfErrors[0]}</strong>
                                    </span>`
                                ); 
                                $('#' + field).addClass('is-invalid');
                            
                         });
                          
                  } else {

                      //jelo je uspesno dodato, ukloni sve poruke sa greskama

                      $('span.invalid-feedback').remove();
                      $('.is-invalid').removeClass('is-invalid');
                      if($("#formaWrapper > div.alert-success").length == 0){
                        var content = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>${response.message}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                       </div>`;

                        $('#formaWrapper').prepend(content);
                      
                    }
                }
            
            }
          });
       });
    });
    
             