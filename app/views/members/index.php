<?php /** @var array $members */ ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevClub Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6fb; }
        .card { border: none; box-shadow: 0 8px 30px rgba(0,0,0,0.06); }
        .table thead th { background: #0d6efd; color: #fff; border: none; }
        .badge-year { font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3 gap-3">
        <div>
            <h1 class="h3 mb-1">ระบบสมาชิก DevClub</h1>
            <p class="text-muted mb-0">เพิ่ม / แก้ไข / ลบ สมาชิกชมรม</p>
        </div>
        <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#memberModal" id="btnAdd">
            + เพิ่มสมาชิกใหม่
        </button>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $err): ?>
                <div><?= htmlspecialchars($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($success)): ?>
        <div class="alert alert-success mb-3"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">รหัส</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>อีเมล</th>
                        <th>สาขา</th>
                        <th class="text-center">ปีการศึกษา (พ.ศ.)</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($members)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">ยังไม่มีข้อมูลสมาชิก</td></tr>
                    <?php else: ?>
                        <?php foreach ($members as $m): ?>
                            <tr>
                                <td class="text-center fw-semibold"><?= (int)$m['id'] ?></td>
                                <td><?= htmlspecialchars($m['full_name']) ?></td>
                                <td><?= htmlspecialchars($m['email']) ?></td>
                                <td><?= htmlspecialchars($m['major']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark badge-year"><?= (int)$m['academic_year'] ?></span>
                                </td>
                                <td class="text-end">
                                    <button
                                        class="btn btn-sm btn-outline-primary me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#memberModal"
                                        data-id="<?= (int)$m['id'] ?>"
                                        data-name="<?= htmlspecialchars($m['full_name'], ENT_QUOTES) ?>"
                                        data-email="<?= htmlspecialchars($m['email'], ENT_QUOTES) ?>"
                                        data-major="<?= htmlspecialchars($m['major'], ENT_QUOTES) ?>"
                                        data-year="<?= (int)$m['academic_year'] ?>"
                                    >แก้ไข</button>
                                    <form method="post" class="d-inline">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('ยืนยันการลบสมาชิก?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add/Edit -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">เพิ่มสมาชิกใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="memberForm" method="post" novalidate>
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" id="memberId">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" class="form-control" id="fullName" name="full_name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
                        <div class="invalid-feedback">กรุณากรอกชื่อ-นามสกุล</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        <div class="invalid-feedback">รูปแบบอีเมลไม่ถูกต้อง</div>
                    </div>
                    <div class="mb-3">
                        <label for="major" class="form-label">สาขาที่ศึกษา</label>
                        <input type="text" class="form-control" id="major" name="major" required value="<?= htmlspecialchars($_POST['major'] ?? '') ?>">
                        <div class="invalid-feedback">กรุณากรอกสาขาที่ศึกษา</div>
                    </div>
                    <div class="mb-3">
                        <label for="academicYear" class="form-label">ปีการศึกษา (พ.ศ.)</label>
                        <input type="number" min="2500" max="2700" class="form-control" id="academicYear" name="academic_year" required value="<?= htmlspecialchars($_POST['academic_year'] ?? '') ?>">
                        <div class="invalid-feedback">กรุณากรอกปีการศึกษาระหว่าง 2500-2700</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="btnSave">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const memberModalEl = document.getElementById('memberModal');
const memberForm = document.getElementById('memberForm');
const btnAdd = document.getElementById('btnAdd');

const resetForm = () => {
    memberForm.reset();
    memberForm.classList.remove('was-validated');
    memberForm.querySelector('#memberId').value = '';
};

btnAdd.addEventListener('click', () => {
    resetForm();
    document.getElementById('memberModalLabel').textContent = 'เพิ่มสมาชิกใหม่';
});

memberModalEl.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    if (!button || !button.dataset.id) {
        resetForm();
        document.getElementById('memberModalLabel').textContent = 'เพิ่มสมาชิกใหม่';
        return;
    }
    document.getElementById('memberModalLabel').textContent = 'แก้ไขสมาชิก';
    memberForm.querySelector('#memberId').value = button.dataset.id;
    memberForm.querySelector('#fullName').value = button.dataset.name;
    memberForm.querySelector('#email').value = button.dataset.email;
    memberForm.querySelector('#major').value = button.dataset.major;
    memberForm.querySelector('#academicYear').value = button.dataset.year;
});

document.getElementById('btnSave').addEventListener('click', () => {
    if (!memberForm.checkValidity()) {
        memberForm.classList.add('was-validated');
        return;
    }
    memberForm.submit();
});
</script>
</body>
</html>
