<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id='customersTable' width='100%'>
                        <thead>
                        <tr>
                            <td>#ID</td>
                            <td>#Name</td>
                            <td>#Phone Number</td>
                            <td>#Email Address</td>
                            <td>#Budget</td>
                            <td>#Message</td>
                            <td>#Action</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Script -->
<script type="text/javascript">
    $(document).ready(function(){

        var customerDetailsRoute = "/customers/details/";
        // DataTable
        $('#customersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('customers.getCustomers')}}",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'phone' },
                { data: 'email' },
                { data: 'budget' },
                { data: 'message' },
                {data: null, render: function (data){return '<a href="'+customerDetailsRoute+data.id+'">Details</a>';}}
            ],
            createdRow: function(row, data, type, name ) {
                console.log(data, name);
//             }
            },
        });

    });
</script>
