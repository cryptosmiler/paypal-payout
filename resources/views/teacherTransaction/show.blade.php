@extends('_layouts.master')

@section('body')
    <div class="flex justify-between">
        <h3 class="text-gray-700 text-3xl font-medium"> {{ app('language')['teacher_transactions'] }} </h3>

        <a
            type="button"
            id="download-pdf"
            class="px-4 py-2 bg-green-900 text-gray-200 rounded-md hover:bg-green-800 focus:outline-none focus:bg-green-800 flex gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
            {{ app('language')['download'] }}
        </a>
    </div>

    <div class="flex flex-col mt-8" id="html-content">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @php
                            $i = 1;
                        @endphp
                        @foreach($teacherTransactions as $teacherTransaction)
                            <tr>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $i++ }}</td>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacherTransaction->teacher->first_name . " " . $teacherTransaction->teacher->last_name}}</td>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacherTransaction->teacher->email }}</td>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacherTransaction->teacher->phone_prefix . " " . $teacherTransaction->teacher->phone }}</td>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{ $teacherTransaction->created_at }}</td>
                               <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">$ {{ $teacherTransaction->amount }}</td>
                               
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="p-2">
                    {{ $teacherTransactions->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script>
        document.getElementById("download-pdf").addEventListener("click", function() {
            const element = document.getElementById("html-content"); // Get the HTML element to be converted to PDF
            html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL("image/png"); // Convert canvas to image data
                const pdf = new jsPDF(); // Initialize jsPDF
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight); // Add image to PDF
                pdf.save("converted-document.pdf"); // Save PDF
            });
        });
    </script>
@endsection