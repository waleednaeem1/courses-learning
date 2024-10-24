<x-app-layout>
     <div id="faqAccordion" class="container mt-4">
         <div class="row">
            <div class="col-lg-12">
               <div class="card mb-3">
                  <div class="card-header d-flex justify-content-between">
                      <div class="header-title">
                          <h4 class="card-title">Need some help?</h4>
                      </div>
                  </div>
                  <div class="card-body">
                     <p>Please see below our frequently asked questions.</p>
                     <p>If you still have a question please do not hesitate to <a href="{{route('footer.contact')}}" style="color: blueviolet">get in touch</a>.</p>
                 </div>
               </div>

               <h4 class="mb-4">General</h4>

               <div class="accordion" id="accordionExample">
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading1">
                        <button class="course_list accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                           Why choose Colorful CE?
                        </button>
                     </h2>
                     <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>There is a plethora of courses available for clinical skills and when we think of CE for vet practice staff, we generally think about veterinarians and vet technicians improving their practical clinical skills. But what about that all important first step on the patient’s pathway to receiving the treatment made possible by those clinical skills? If this part of the patient’s journey is not done well and in unison with the rest of the team then it can have negative knock-on effects on the patient’s treatment, the relationship with the client, the business & its staff. That’s why we feel it’s important to help ALL roles in veterinary practice (veterinarians, vet techs, CSR’s & managers) contribute to the 4 outcomes of successful veterinary practice.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading2">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                           What types of CE do you offer?
                        </button>
                     </h2>
                     <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Colourful CE is an online non-clinical CE provider.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading3">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                           I’m not in the USA, can I still take part?
                        </button>
                     </h2>
                     <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Of course you can. Please be aware that all course content is provided in English. Please also be mindful that some of our courses involve USA legislation and so this may differ to the legislation in your country.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading4">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                           I’m busy and concerned I might not be able to complete my course in time?
                        </button>
                     </h2>
                     <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>We understand how busy life in practice can be, so for this reason there is no time limit on any of our courses. Once purchased, it’s yours for life and you can work through it at your own pace.</p>
                        </div>
                     </div>
                  </div>

                  <h4 class="mb-4">Training Hub</h4>

                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading5">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                           I can’t log in, what shall I do?
                        </button>
                     </h2>
                     <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                        <p>Please make sure that there are no spaces or spelling errors in your email and password. If you can’t remember your password, please use the ‘forgotten your password?’ option at login <a href="{{route('login')}}" style="color: blueviolet">here</a>. Alternatively, if you’re not sure which email you’re registered with, please get in touch with your details and we can let you know.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading6">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                           Can I access my course and the content after I’ve completed it?
                        </button>
                     </h2>
                     <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Yes. The course and all content will be available to refer to as and when you wish. You just need to login, click into the course from your dashboard and you’ll be able to access any section you need to reflect on.  If your practice has purchased your training and you leave the practice your completed courses will not be deleted and will still be available for you to review.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading7">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                           Can I print the course content out?
                        </button>
                     </h2>
                     <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>I’m sure you can appreciate that in the current climate it is not sustainable for us as a company to suggest large quantities of material be printed. For this reason, we choose to provide our courses in a format that encourages minimal waste.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading8">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                           Will I receive a certificate and how do I get it?
                        </button>
                     </h2>
                     <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>A certificate will be available to download from your dashboard as soon as you’ve completed and passed a course. Hard copy certificates are issued to CertCSR completers only.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading9">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                           If I’m unsure of anything and need to contact you during a course, who do I contact?
                        </button>
                     </h2>
                     <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Please email <a href="mailto:info@colorfulce.com" style="color: blueviolet">info@colorfulce.com</a> and we would be happy to help.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading10">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                           Who marks my course work and how long do I have to wait to get my results?
                        </button>
                     </h2>
                     <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Course work for the Gold level of the CertCSR are marked by external examiners. Our examiners and tutors have the relevant knowledge and expertise in the subjects they assess.</p>
                           <p class="mt-3">We will endeavour to mark submitted course work within 48 hours of submission (excluding weekends and bank holidays).</p>
                        </div>
                     </div>
                  </div>

                  <h4 class="mb-3">Payment</h4>

                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading11">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                           Can my practice pay for me and if so, how do they do this?
                        </button>
                     </h2>
                     <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>Absolutely! In fact, we actively encourage your practice to purchase CE for you as part of your CE budget. When you reach checkout, you will be given the option to submit a request to your practice to pay for the course for you. This will send an email to your practices Colourful CE account administrator letting them know and they can then login and process the payment as per your practices invoicing protocol. Please be aware that you will need to be connected to a practice on our system for this to be actioned.</p>
                        </div>
                     </div>
                  </div>
                  <div class="accordion-item colorful_faq mb-3">
                     <h2 class="accordion-header" id="heading12">
                        <button class="course_list accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                           Do you offer instalment plans if I’m funding a course myself?
                        </button>
                     </h2>
                     <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                           <p>We understand that sometimes your practice may be unable to purchase a course for you due to various reasons. We are therefore happy to discuss payment options with you. Simply email us with your situation and we’ll try our best to help.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

</x-app-layout>