<?php
// ============================================================
// Question One: Hospital Patient Appointment Management System
// ============================================================
// This file demonstrates:
// 1. Abstract Class (Person)
// 2. Inheritance (Patient extends Person)
// 3. Dependency Injection (Appointment receives DB connection)
// 4. Booking an appointment and storing it in the database
// 5. Polymorphism (different views for admin vs receptionist)
// ============================================================

// Include required files
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/classes/Patient.php';
require_once __DIR__ . '/classes/Appointment.php';

// ---- Step 1: Create database connection ----
$database = new Database();
$db = $database->getConnection();

// ---- Step 2: Create a Patient object (Inheritance demo) ----
// Patient extends the abstract Person class
$patient = new Patient(1, "John Doe", "0781234567");

// ---- Step 3: Dependency Injection ----
// The Appointment class receives the database connection
// through its constructor (Dependency Injection pattern)
$appointment = new Appointment($db);

// ---- Step 4: Book a new appointment ----
$bookingMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
    $appointment->setPatientId($_POST['patient_id']);
    $appointment->setAppointmentDate($_POST['appointment_date']);
    $appointment->setDoctorName($_POST['doctor_name']);

    if ($appointment->bookAppointment()) {
        $bookingMessage = "<p style='color:green; font-weight:bold;'>
            Appointment booked successfully!</p>";
    } else {
        $bookingMessage = "<p style='color:red; font-weight:bold;'>
            Failed to book appointment.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Appointment Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 0 20px;
            background-color: #f5f5f5;
        }
        h1, h2 {
            color: #2c3e50;
        }
        .section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #34495e;
        }
        .concept-note {
            background: #eaf7ea;
            border-left: 4px solid #27ae60;
            padding: 10px 15px;
            margin: 10px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h1>Hospital Patient Appointment Management System</h1>

<!-- ====================================================== -->
<!-- SECTION 1: Demonstrate Abstract Class and Inheritance   -->
<!-- ====================================================== -->
<div class="section">
    <h2>1. Abstract Class (Person) and Inheritance (Patient extends Person)</h2>
    <div class="concept-note">
        <strong>Concept:</strong> The <code>Person</code> class is declared as 
        <code>abstract</code>, meaning it cannot be instantiated directly. The 
        <code>Patient</code> class <strong>extends</strong> Person and inherits 
        its properties (<code>$name</code>, <code>$phoneNumber</code>) and must 
        implement the abstract method <code>displayDetails()</code>.
    </div>
    <p><strong>Patient Created:</strong></p>
    <ul>
        <li><strong>Patient ID:</strong> <?php echo $patient->getPatientId(); ?></li>
        <li><strong>Name:</strong> <?php echo $patient->getName(); ?></li>
        <li><strong>Phone:</strong> <?php echo $patient->getPhoneNumber(); ?></li>
    </ul>
</div>

<!-- ====================================================== -->
<!-- SECTION 2: Demonstrate Dependency Injection              -->
<!-- ====================================================== -->
<div class="section">
    <h2>2. Dependency Injection (Appointment Class)</h2>
    <div class="concept-note">
        <strong>Concept:</strong> The <code>Appointment</code> class does NOT 
        create its own database connection. Instead, the connection is 
        <strong>injected</strong> through the constructor: 
        <code>new Appointment($db)</code>. This is the 
        <strong>Dependency Injection</strong> design pattern - the class depends 
        on the database connection, and that dependency is provided from outside.
    </div>
    <p>The Appointment object was created with an injected database connection:</p>
    <pre style="background:#f4f4f4; padding:10px; border-radius:4px;">
$database = new Database();
$db = $database->getConnection();

// Dependency Injection: $db is passed into Appointment
$appointment = new Appointment($db);
    </pre>
</div>

<!-- ====================================================== -->
<!-- SECTION 3: Book an Appointment (Form)                    -->
<!-- ====================================================== -->
<div class="section">
    <h2>3. Book an Appointment (Stored in Database)</h2>
    <div class="concept-note">
        <strong>Concept:</strong> The <code>bookAppointment()</code> method 
        inserts a new appointment record into the database using a prepared 
        statement to prevent SQL injection.
    </div>

    <?php echo $bookingMessage; ?>

    <form method="POST" action="">
        <label for="patient_id">Patient ID:</label>
        <input type="number" id="patient_id" name="patient_id" required 
               placeholder="Enter Patient ID (e.g., 1, 2, 3)">

        <label for="appointment_date">Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" required>

        <label for="doctor_name">Doctor's Name:</label>
        <input type="text" id="doctor_name" name="doctor_name" required 
               placeholder="e.g., Dr. Ochieng">

        <button type="submit" name="book">Book Appointment</button>
    </form>
</div>

<!-- ====================================================== -->
<!-- SECTION 4: Display All Appointments                      -->
<!-- ====================================================== -->
<div class="section">
    <h2>4. All Appointments (Retrieved from Database)</h2>
    <?php
    // Create a fresh Appointment object with injected DB connection
    $appointmentList = new Appointment($db);
    $stmt = $appointmentList->getAllAppointments();

    if ($stmt->rowCount() > 0) {
        echo "<table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Doctor Name</th>
                </tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$row['appointment_id']}</td>
                    <td>{$row['patient_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['appointment_date']}</td>
                    <td>{$row['doctor_name']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No appointments found in the database.</p>";
    }
    ?>
</div>

<!-- ====================================================== -->
<!-- SECTION 5: Demonstrate Polymorphism                      -->
<!-- ====================================================== -->
<div class="section">
    <h2>5. Polymorphism - Different Views for the Same Patient</h2>
    <div class="concept-note">
        <strong>Concept:</strong> <strong>Polymorphism</strong> means "many forms". 
        The same method <code>displayDetails()</code> behaves differently based on 
        the view type parameter. The Administrator sees ALL patient details 
        (including Patient ID), while the Receptionist sees limited information 
        (only name and phone number). This is the same object calling the same 
        method, but producing different output.
    </div>

    <?php
    // Create patient objects for polymorphism demonstration
    $patient1 = new Patient(1, "John Doe", "0781234567");
    $patient2 = new Patient(2, "Jane Smith", "0729876543");
    $patient3 = new Patient(3, "Alice Mwangi", "0711223344");

    // Store patients in an array to iterate over them
    $patients = [$patient1, $patient2, $patient3];

    echo "<h3>Administrator View (Full Details):</h3>";
    foreach ($patients as $p) {
        // Polymorphism: calling displayDetails with 'admin' view
        echo $p->displayDetails('admin');
    }

    echo "<h3>Receptionist View (Limited Details):</h3>";
    foreach ($patients as $p) {
        // Polymorphism: same method, different behavior with 'receptionist' view
        echo $p->displayDetails('receptionist');
    }
    ?>
</div>

</body>
</html>
