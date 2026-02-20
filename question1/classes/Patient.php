<?php
// ============================================================
// Patient Class - Extends the Abstract Person Class
// Demonstrates INHERITANCE and POLYMORPHISM
// ============================================================

require_once __DIR__ . '/Person.php';

class Patient extends Person {
    // Additional property specific to Patient
    private $patientId;

    /**
     * Constructor - calls parent constructor and sets patient-specific attributes.
     * @param int    $patientId   The unique patient ID
     * @param string $name        The patient's name
     * @param string $phoneNumber The patient's phone number
     */
    public function __construct($patientId, $name, $phoneNumber) {
        // Call the parent (Person) constructor
        parent::__construct($name, $phoneNumber);
        $this->patientId = $patientId;
    }

    // Getter for patient ID
    public function getPatientId() {
        return $this->patientId;
    }

    /**
     * POLYMORPHISM: Displays patient details differently
     * depending on whether the viewer is an Administrator
     * or a Receptionist.
     *
     * - Administrator View: Shows ALL details (ID, name, phone)
     * - Receptionist View: Shows only name and phone (no ID)
     *
     * @param string $viewType 'admin' or 'receptionist'
     * @return string HTML formatted patient details
     */
    public function displayDetails($viewType) {
        if ($viewType === 'admin') {
            // Administrator View - Full details including Patient ID
            return "<div style='border:1px solid #333; padding:10px; margin:10px 0; background:#f0f8ff;'>
                        <h3>Administrator View</h3>
                        <p><strong>Patient ID:</strong> {$this->patientId}</p>
                        <p><strong>Name:</strong> {$this->name}</p>
                        <p><strong>Phone Number:</strong> {$this->phoneNumber}</p>
                    </div>";
        } elseif ($viewType === 'receptionist') {
            // Receptionist View - Limited details (no Patient ID for privacy)
            return "<div style='border:1px solid #333; padding:10px; margin:10px 0; background:#fff8f0;'>
                        <h3>Receptionist View</h3>
                        <p><strong>Name:</strong> {$this->name}</p>
                        <p><strong>Phone Number:</strong> {$this->phoneNumber}</p>
                    </div>";
        } else {
            return "<p>Invalid view type specified.</p>";
        }
    }
}
?>
