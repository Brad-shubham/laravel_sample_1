<!DOCTYPE html>
<html lang="en">
<head>
    <title>Students Status Report</title>
    <style type="text/css">
        h1 {
            font-size: 30px !important;
        }

        h2 {
            font-size: 20px !important;
        }

        h5 {
            font-size: 15px !important;
        }

        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        table {
            width: 100%;
        }

        th {
            height: 50px;
        }

        table th,
        table td {
            text-align: center;
            padding: 0.75rem;
            font-size: 12px !important;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div id="admin-app" class="app">
    <div id="wrapper">
        <main class="container-fluid text-center mt-5 mb-5">
            <section class="table-responsive mb-3">
                <div>
                    <h1>Students Status Report</h1>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Phone Number</th>
                        <th>Date Enrolled</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->profile->full_name }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>{{ $student->profile->date_enrolled }}</td>
                            <td>{{ $student->profile->activity_status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</div>
</body>
</html>

