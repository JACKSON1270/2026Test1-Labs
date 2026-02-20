<?php
// ============================================================
// Appointment Class
// Receives the database connection through DEPENDENCY INJECTION
// (the connection is passed in via the constructor, not created
//  inside the class - this is the Dependency Injection pattern)
// ============================================================

class Appointment {
    // Private properties
    private $conn;              // Database connection (injected)
    private $appointmentDate;
    private $doctorName;
    private $patientId;

    // Table name
    private $table = "appointments";

    /**
     * Constructor - receives the database connection via
     * DEPENDENCY INJECTION. Instead of creating its own
     * database connection, this class receives it from outside.
     *
     * @param PDO $dbConnection The database connection object
     */
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Setter methods
    public function setAppointmentDate($date) {
        $this->appointmentDate = $date;
    }

    public function setDoctorName($doctorName) {
        $this->doctorName = $doctorName;
    }

    public function setPatientId($patientId) {
        $this->patientId = $patientId;
    }

    // Getter methods
    public function getAppointmentDate() {
        return $this->appointmentDate;
    }

    public function getDoctorName() {
        return $this->doctorName;
    }

    public function getPatientId() {
        return $this->patientId;
    }

    /**
     * Book an appointment and store it in the database.
     * Uses prepared statements to prevent SQL injection.
     *
     * @return bool True if booking was successful, false otherwise
     */
    public function bookAppointment() {
        // SQL query using prepared statement
        $query = "INSERT INTO " . $this->table . " 
                  (patient_id, appointment_date, doctor_name) 
                  VALUES (:patient_id, :appointment_date, :doctor_name)";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Sanitize input data
        $this->patientId = htmlspecialchars(strip_tags($this->patientId));
        $this->appointmentDate = htmlspecialchars(strip_tags($this->appointmentDate));
        $this->doctorName = htmlspecialchars(strip_tags($this->doctorName));

        // Bind parameters
        $stmt->bindParam(":patient_id", $this->patientId);
        $stmt->bindParam(":appointment_date", $this->appointmentDate);
        $stmt->bindParam(":doctor_name", $this->doctorName);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve all appointments from the database.
     * @return PDOStatement
     */
    public function getAllAppointments() {
        $query = "SELECT a.appointment_id, a.appointment_date, a.doctor_name, 
                         p.patient_id, p.name, p.phone_number
                  FROM " . $this->table . " a
                  INNER JOIN patients p ON a.patient_id = p.patient_id
                  ORDER BY a.appointment_date ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
