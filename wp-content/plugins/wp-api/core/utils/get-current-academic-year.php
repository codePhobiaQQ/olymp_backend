<?php

function getCurrentAcademicYear() {
    $now = new DateTime();
        $currentYear = (int) $now->format('Y');
        $currentMonth = (int) $now->format('n'); // Months are 1-based (1 = January, 12 = December)

        // Academic year starts in September
        $academicYearStart;
        $academicYearEnd;

        if ($currentMonth >= 9) { // September (9) to December (12)
            $academicYearStart = $currentYear;
            $academicYearEnd = $currentYear + 1;
        } else { // January (1) to August (8)
            $academicYearStart = $currentYear - 1;
            $academicYearEnd = $currentYear;
        }

        return "[{$academicYearStart}-{$academicYearEnd}]";
}