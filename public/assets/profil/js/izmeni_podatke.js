    toastr.options.preventDuplicates = true;
    $(document).ready(function () {
       
        $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
        
        $confirmPasswordWrapper = $("#confirm-password-wrapper");
        $passwordConfirmation = $("#confirm-password");
        $lozinkaInput = $("input[name='password']");
        $lozinkaInput.prop('disabled',true);
        $telefonInput = $("input[name='telefon']");
        $passwordConfirmation.prop('disabled',true);

        $(document).on('click','#izmeni-lozinku',function(){
            $confirmPasswordWrapper.removeClass('d-none');
            $confirmPasswordWrapper.fadeIn('normal',function(){
            $.each([$passwordConfirmation,$lozinkaInput], function (index, element) { 
                    element.prop('disabled',false);
                    element.removeClass('form-control-plaintext');
                    element.addClass('form-control');
                    element.prop('readonly',false);
                });
            });
            $(this).blur();
            
        });
        $(document).on('change','input',function(){
            $(this).addClass('changed');
        });
        let formDataBackup = new FormData($("#podaci-forma")[0]);
        $("#podaci-forma").submit(function(event){
            event.preventDefault();
            $("input:not(.changed,[type='hidden'])").prop('disabled',true);
           
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $("div.invalid-feedback").remove();
                    $('.is-invalid').removeClass('is-invalid');
                },
                success: function (response) {
                    if('poruka-uspeh' in response){
                        toastr.success(response['poruka-uspeh']);
                    }
                    if('novi-podaci' in response){
                        uspesnaPromena();
                        $.each(response['novi-podaci'], function (name,vrednost) { 
                             $("#podaci-forma input[name='" + name + "']")
                                .val(vrednost);
                        });
                    }
                   
                    
                },
                error: function(jqXHR){
                    if(jqXHR.status == 422){
                        $("#podaci-forma input")
                            .not(".changed,[type='hidden'],#password,#confirm_password")
                            .prop('disabled',false);
                        var greske = jqXHR.responseJSON.errors;
                        
                        for(let imePolja in greske ){
                            var selector = "[name='" + imePolja + "']";
                            $greskaDiv = $("<div class='invalid-feedback'></div>");
                            $greskaDiv.text(greske[imePolja]);
                            $(selector).addClass('is-invalid');
                            $(selector).after($greskaDiv);
                        }
                    }
                }
            });
            
        });
        $("#izmeni-button").click(function(event){
            $inputPolja = $("#podaci-forma")
                            .find('input')
                            .not("[name='kreiran'],#password,#confirm-password");
            if($inputPolja.filter(".form-control").length == 0){
                $inputPolja.prop('readonly',false);
                $inputPolja.removeClass('form-control-plaintext');
                $inputPolja.addClass('form-control');
                $span = $(this).children('span');
                izmeni($span,$telefonInput,$(this));

            }
            
        });
        $(document).on('click','#ponisti-button',function(){
            for(var polje of formDataBackup.entries()){
                if(['name','email','telefon'].includes(polje[0])){
                   
                    $(`[name="${polje[0]}"]`).val(polje[1]);
                }
            }
            $dugme = $("#izmeni-button");
            $span = $dugme.children('span');
            $telefonInput = $("input[name='telefon']");
            ponistiIzmene($span,$telefonInput,$dugme);
        
        });
        

        //helper funkcije
        function ponistiIzmene($span,$telefonInput,$dugme){
            $("input:not(.changed,[type='hidden'])").prop('disabled',false);
            $('.changed').removeClass('changed')
            $inputPolja = $("#podaci-forma input");
            $inputPolja.prop('readonly',true);
            $inputPolja.removeClass('form-control');
            $inputPolja.addClass('form-control-plaintext');
            $lozinkaInput.prop('disabled',true);
            $(".invalid-feedback").remove();
            $(".is-invalid").removeClass('is-invalid');
            $lozinkaInput.siblings('button').fadeOut('normal',function(){
                $(this).remove();
            });
            $confirmPasswordWrapper.fadeOut('normal');
            $passwordConfirmation.prop('disabled',true);
            $()
            if($telefonInput.parent('div.input-group').length !== 0){
                    $telefonInput.siblings('div.input-group-prepend').remove();
                    $telefonInput.unwrap();
                    
                }
                $("#ponisti-button").fadeOut('normal',function(){
                    $(this).remove();
                });
            $span.fadeOut('normal',function(){
                //promeni tekst buttona i ikonicu
                $(this).empty();
                $(this).text('Izmeni');
                $dugme.attr('type','button');
                $(this).append('<i class="fa fa-pencil ml-1" aria-hidden="true"></i>');
                $(this).fadeIn('fast');
                $dugme.blur();
                $lozinkaInput.val('{{ md5(rand()) }}');
                $passwordConfirmation.val('{{ md5(rand()) }}');
            });
           
        }
        function izmeni($span,$telefonInput,$dugme){
            if($("#izmeni-lozinku").length == 0){
                $izmeniLozinku = $(`
                        <button type="button" id="izmeni-lozinku" class="btn btn-primary rounded mt-2">
                            Promeni lozinku
                        </button>
                `);
                $izmeniLozinku.hide().insertAfter($lozinkaInput).fadeIn('normal');
            }
            if($telefonInput.val().startsWith("381")){
                $telefonInput.val($telefonInput.val().slice(3));
            }
            if($telefonInput.parent('div.input-group').length == 0){
                    $inputGroupDiv = $("<div class='input-group'></div>");
                    $telefonInput
                        .wrap($inputGroupDiv)
                        .before(
                            `<div class="input-group-prepend">
                                <div class="input-group-text">+381</div>
                            </div>`
                        );
                        
            }
            $span.fadeOut('normal',function(){
                $(this).text('Sačuvaj');
                $ponistiDugme =
                        $(`<button type="button" id="ponisti-button" class=" ml-2 btn px-3 py-2 btn-danger rounded">
                            <span>
                                Poništi<i class="fa fa-times ml-1" aria-hidden="true"></i>
                            </span>
                        </button>`);
                $ponistiDugme.hide().appendTo('#button-wrapper').fadeIn('fast');
                $dugme.attr('type','submit');
                
                $(this).append('<i class="fa fa-check ml-1" aria-hidden="true"></i>');
                $(this).fadeIn('fast');
                $dugme.blur();
            });
        }
      
        function uspesnaPromena(){
           $dugme = $("#izmeni-button");
           $span = $dugme.children('span');
           ponistiIzmene($span,$telefonInput,$dugme);
           formDataBackup = new FormData($("#podaci-forma")[0]);
            
        }  
    });