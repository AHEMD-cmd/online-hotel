@extends('front.layout.app')

@section('main_content')
    <div class="page-top">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Contact us</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <form action="{{ route('contact.send.email') }}" method="post" class="contact-form" id="contactForm">
                        @csrf
                        <div class="contact-form">
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" name="name">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address *</label>
                                <input type="text" class="form-control" name="email">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message *</label>
                                <textarea class="form-control" rows="3" name="message"></textarea>
                                <span class="text-danger error-text message_error"></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary bg-website">Send Message</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="map">
                        {!! $data->contact_map !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $(".contact-form").on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: formData,
                    beforeSend: function() {
                        $(".error-text").text(""); // مسح الأخطاء السابقة
                    },
                    success: function(response) {
                        if (response.code == 1) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end', // Show at top-right corner
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000 // Auto close after 3 seconds
                            });

                            form[0].reset(); // إعادة تعيين النموذج
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('.' + key + '_error').text(value[
                                0]); // عرض الأخطاء تحت كل حقل
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: "Failed to send email!",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
