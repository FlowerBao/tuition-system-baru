<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Fee Payment Reminder
        </h2>
    </x-slot>

    <div class="py-8 px-6 bg-white shadow sm:rounded-lg">
        <p class="text-lg mb-4">Dear Parent,</p>

        <p class="mb-4">
            This is a friendly reminder that your child
            <strong>{{ $student->name }}</strong> (IC: {{ $student->ic }})
            has outstanding fee payments.
        </p>

        <p class="mb-2"><strong>Student Level:</strong> {{ $student->level }}</p>

        <h4 class="font-semibold mt-4 mb-2 text-gray-700">Enrolled Subjects:</h4>
        <ul class="list-disc list-inside mb-4">
            @foreach ($student->subjects as $subject)
                <li>
                    {{ $subject->name }} - RM{{ number_format($subject->price, 2) }}
                    ({{ $subject->level }} - {{ $subject->subject_class }})
                </li>
            @endforeach
        </ul>

        <p class="mb-4">
            Please log in to the parent portal to complete the payment.
        </p>

        <p class="text-gray-700">
            Thank you,<br>
            <span class="font-semibold">Admin Team</span>
        </p>
    </div>
</x-app-layout>
