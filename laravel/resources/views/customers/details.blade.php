<script src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mx-auto my-5 p-5">
                <div class="w-full">
                    <div class="bg-white p-3 shadow-sm rounded-sm p-10">
                        <div class="text-gray-700">
                            <div class="grid md:grid-cols-2 text-lg p-8">
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">Name</div>
                                    <div class="px-4 py-2">{{$customer->name}}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">Phone Number</div>
                                    <div class="px-4 py-2">{{$customer->phone}}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">Email Address</div>
                                    <div class="px-4 py-2">{{$customer->email}}</div>
                                </div>
                                <div class="grid grid-cols-2">
                                    <div class="px-4 py-2 font-semibold">Desired Budget</div>
                                    <div class="px-4 py-2">{{$customer->budget}}</div>
                                </div>
                            </div>
                            <div class="grid text-lg pad-message">
                                <div class="grid ">
                                    <div class="px-4 py-2 font-semibold">Message</div>
                                    <div class="px-4 py-2">{{$customer->message}}</div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <button id="wpAccountCreation" data-id="{{$customer->id}}" class="block rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs">Create WordPress Account</button>
                        <br />
                    </div>
                    <!-- End of about section -->
                    <!-- End of profile tab -->
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
    $(document).ready(function(){
        $('#wpAccountCreation').on('click', function (){
            var postData = { id: $(this).data('id') };
            var url = '{{route("customers.createWpAccount")}}';
            async function createWpUser(){
                try {
                    var response = await axios.post(url, postData);
                    var res = response.data;
                    if(!!res.account_created && !!res.user_id){
                        showMessage('success', 'Dene!', 'WP profile has been created regarding customer data with user ID: ' + res.user_id + '.');
                    } else if(response.data.error){
                        showMessage('error', 'Error!', 'Something went wrong!');
                    } else {
                        showMessage('info', 'Info!', 'A WP user already exist with the customer email!');
                    }
                } catch (errors) {
                    console.error(errors);
                }
            }
            createWpUser();

            function showMessage(icon, title, message){
                swal({
                    title: title,
                    icon: icon,
                    text: message,
                    timer:7000,
                }).then((value) => {
                }).catch(swal.noop);
            }
        })
    })
</script>


