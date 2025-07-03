<x-app-layout>
    <head>
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>

    <div class="max-w-7xl mx-auto py-10 px-6">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8">📧 Send Professional Email</h2>

        <div id="alert" class="hidden mb-4 p-4 rounded-md"></div>

        <form id="emailForm" method="POST" action="{{ route('email-sender.store') }}">
            @csrf

            <!-- Template Type -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Template Type</label>
                <select id="templateType" class="w-full px-4 py-2 border rounded-md">
                    <option value="">-- Select a Template --</option>
                    <option value="discount">Discount Offer</option>
                    <option value="monthly_offer">Monthly Offer</option>
                    <option value="reminder">Reminder</option>
                </select>
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Subject</label>
                <input
                    type="text"
                    name="subject"
                    required
                    class="w-full px-4 py-2 border rounded-md"
                    placeholder="e.g. Exciting Trading Update!"
                >
                @error('subject')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Heading -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Heading</label>
                <input
                    type="text"
                    name="heading"
                    required
                    class="w-full px-4 py-2 border rounded-md"
                    placeholder="e.g. Hello Traders, Big News!"
                >
                @error('heading')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Body -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Body (You can use Markdown)</label>
                <textarea
                    name="body"
                    rows="6"
                    required
                    class="w-full px-4 py-2 border rounded-md"
                    placeholder="# Your Monthly Offer\n\nDiscover our latest deal tailored just for you..."
                ></textarea>
                @error('body')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Recipients -->
            <div class="mb-4">
                <label class="block font-semibold text-gray-700">Recipients</label>
                <select id="userSelect" name="users[]" multiple class="w-full select2">
                    <option value="all">Send to All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Search and select users. Hold Ctrl (Windows) or Command (Mac) to select multiple.</p>
                @error('users')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700"
                id="submitBtn"
            >Send Email</button>
        </form>
    </div>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#userSelect').select2({
                placeholder: "Select recipients",
                allowClear: true,
                width: '100%'
            });

            // Autofill templates
            $('#templateType').on('change', function() {
                const subjectInput = $('input[name="subject"]');
                const headingInput = $('input[name="heading"]');
                const bodyTextarea = $('textarea[name="body"]');

                const templates = {
                    discount: {
                        subject: 'Exclusive Discount Just For You!',
                        heading: 'Big Savings Ahead!',
                        body: `# Hello Trader,\n\nWe're excited to offer you an exclusive **20% discount** on your next subscription.\n\nDon't miss out on this limited-time offer!`
                    },
                    monthly_offer: {
                        subject: 'Your Exclusive Monthly Offer Awaits!',
                        heading: 'Special Deal This Month!',
                        body: `# Hello Trader,\n\nThis month, we're rolling out a special offer just for you! Enjoy **premium features at a reduced rate** for a limited time.\n\nAct now to elevate your trading experience!`
                    },
                    reminder: {
                        subject: 'Friendly Reminder from Next Gen AI Trader',
                        heading: 'Don’t Miss Out!',
                        body: `# Hello!\n\nJust a quick reminder to check your trading dashboard and review your subscription.\n\nStay ahead with Next Gen AI Trader!`
                    }
                };

                const selected = templates[this.value];
                if (selected) {
                    subjectInput.val(selected.subject);
                    headingInput.val(selected.heading);
                    bodyTextarea.val(selected.body);
                } else {
                    subjectInput.val('');
                    headingInput.val('');
                    bodyTextarea.val('');
                }
            });

            // AJAX form submission
            $('#emailForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $submitBtn = $('#submitBtn');
                const $alert = $('#alert');

                $submitBtn.prop('disabled', true).text('Sending...');
                $alert.removeClass('bg-green-100 bg-red-100 text-green-700 text-red-700').addClass('hidden').empty();

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        $alert
                            .removeClass('hidden')
                            .addClass('bg-green-100 text-green-700')
                            .text(response.success || 'Email sent successfully!');
                        $form[0].reset();
                        $('#userSelect').val(null).trigger('change'); // Clear select2
                    },
                    error: function(xhr) {
                        $alert.removeClass('hidden').addClass('bg-red-100 text-red-700');
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            const errorMessages = Object.values(errors).flat().join(', ');
                            $alert.text(errorMessages);
                        } else {
                            $alert.text(xhr.responseJSON?.error || 'Failed to send email. Please try again later.');
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Send Email');
                    }
                });
            });
        });
    </script>
</x-app-layout>
