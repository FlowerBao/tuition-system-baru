<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fee Payment Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>Fee Payment Reminder</h2>

    <p>Dear Parent,</p>

    <p>
        This is a friendly reminder that your child
        <strong>{{ $student->name }}</strong> (IC: {{ $student->ic }})
        has outstanding fee payments.
    </p>

    <p><strong>Student Level:</strong> {{ $student->level }}</p>

    <h4>Enrolled Subjects:</h4>
    <ul>
        @foreach ($student->subjects as $subject)
            <li>
                {{ $subject->name }} - RM{{ number_format($subject->price, 2) }}
                ({{ $subject->level }} - {{ $subject->subject_class }})
            </li>
        @endforeach
    </ul>

    <p>Please log in to the parent portal to complete the payment.</p>

    <p style="margin-top: 20px;">
        <a href="{{ url('/login') }}" 
           style="display: inline-block; padding: 10px 20px; background-color: #1D4ED8; color: #ffffff; text-decoration: none; border-radius: 5px;">
            Log In to Parent Portal
        </a>
    </p>

    <p>
        Thank you,<br>
        <strong>Admin Team</strong>
    </p>
</body>
</html>
