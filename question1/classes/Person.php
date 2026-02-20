<?php
// ============================================================
// Abstract Person Class
// Base class that defines the common structure for all persons
// ============================================================

abstract class Person {
    // Protected properties accessible by child classes
    protected $name;
    protected $phoneNumber;

    /**
     * Constructor to initialize common person attributes.
     * @param string $name        The person's name
     * @param string $phoneNumber The person's phone number
     */
    public function __construct($name, $phoneNumber) {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }

    // Getter methods
    public function getName() {
        return $this->name;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * Abstract method to display person details.
     * This MUST be implemented by all child classes,
     * demonstrating POLYMORPHISM - each subclass provides
     * its own implementation of this method.
     *
     * @param string $viewType The type of view ('admin' or 'receptionist')
     * @return string
     */
    abstract public function displayDetails($viewType);
}
?>
