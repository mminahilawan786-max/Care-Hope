<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
requirePatient('login.php');
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Book an appointment | Care-Hope';
$user = loggedInUser();
$errors = [];
$doctors = [];
$form = ['doctor_id' => (string) ($_GET['doctor'] ?? ''), 'appointment_date' => '', 'appointment_time' => '', 'reason' => ''];
$availableTimes = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

try {
    $pdo = getDatabaseConnection();
    $doctors = $pdo->query('SELECT doctors.id, doctors.first_name, doctors.last_name, specialties.name AS specialty FROM doctors INNER JOIN specialties ON specialties.id = doctors.specialty_id WHERE doctors.is_active = 1 ORDER BY doctors.last_name, doctors.first_name')->fetchAll();
} catch (PDOException) {
    $errors[] = 'Doctor availability is temporarily unavailable. Please try again later.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $field => $value) {
        $form[$field] = trim((string) ($_POST[$field] ?? ''));
    }
    $doctorId = filter_var($form['doctor_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $appointmentDate = DateTimeImmutable::createFromFormat('!Y-m-d', $form['appointment_date']);

    if (!csrfIsValid($_POST['csrf_token'] ?? null)) $errors[] = 'Your form session has expired. Please try again.';
    if ($doctorId === false) $errors[] = 'Please choose a doctor.';
    if ($appointmentDate === false || $appointmentDate->format('Y-m-d') !== $form['appointment_date'] || $appointmentDate < new DateTimeImmutable('today')) $errors[] = 'Please select today or a future appointment date.';
    if (!in_array($form['appointment_time'], $availableTimes, true)) $errors[] = 'Please select an available appointment time.';
    if ($form['reason'] === '' || mb_strlen($form['reason']) > 500) $errors[] = 'Please describe the reason for your visit in 500 characters or fewer.';

    if ($errors === []) {
        try {
            $doctorCheck = $pdo->prepare('SELECT id FROM doctors WHERE id = :id AND is_active = 1');
            $doctorCheck->execute(['id' => $doctorId]);
            if ($doctorCheck->fetch() === false) {
                $errors[] = 'The selected doctor is not available. Please choose another doctor.';
            } else {
                $statement = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason) VALUES (:patient_id, :doctor_id, :appointment_date, :appointment_time, :reason)');
                $statement->execute(['patient_id' => $user['id'], 'doctor_id' => $doctorId, 'appointment_date' => $form['appointment_date'], 'appointment_time' => $form['appointment_time'] . ':00', 'reason' => $form['reason']]);
                startSecureSession();
                $_SESSION['flash_success'] = 'Your appointment request has been sent successfully.';
                redirect('patient/appointments.php');
            }
        } catch (PDOException $exception) {
            $errors[] = $exception->getCode() === '23000'
                ? 'That appointment time has just been booked. Please choose another time.'
                : 'We could not book your appointment right now. Please try again later.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="booking-page"><section class="container booking-layout"><div class="booking-intro"><p class="eyebrow">Book an appointment</p><h1>Take the next step toward better health.</h1><p>Choose your doctor, select a convenient time, and send your appointment request securely.</p><div class="booking-steps"><span><b>1</b> Choose a doctor</span><span><b>2</b> Select a time</span><span><b>3</b> Confirm request</span></div></div><form class="booking-form" method="post" novalidate><h2>Appointment details</h2><?php if ($errors !== []): ?><div class="form-message error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><label>Doctor<select name="doctor_id" required><option value="">Select a doctor</option><?php foreach ($doctors as $doctor): ?><option value="<?= e((string) $doctor['id']) ?>" <?= $form['doctor_id'] === (string) $doctor['id'] ? 'selected' : '' ?>><?= e('Dr. ' . $doctor['first_name'] . ' ' . $doctor['last_name'] . ' — ' . $doctor['specialty']) ?></option><?php endforeach; ?></select></label><div class="form-row"><label>Date<input name="appointment_date" type="date" min="<?= e((new DateTimeImmutable('today'))->format('Y-m-d')) ?>" required value="<?= e($form['appointment_date']) ?>"></label><label>Time<select name="appointment_time" required><option value="">Select a time</option><?php foreach ($availableTimes as $time): ?><option value="<?= e($time) ?>" <?= $form['appointment_time'] === $time ? 'selected' : '' ?>><?= e(date('g:i A', strtotime($time))) ?></option><?php endforeach; ?></select></label></div><label>Reason for visit<textarea name="reason" rows="4" maxlength="500" required placeholder="Briefly describe what you would like to discuss."><?= e($form['reason']) ?></textarea></label><button class="button" type="submit">Request appointment</button></form></section></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
