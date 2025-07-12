// public/js/company-profile-form.js
document.addEventListener("DOMContentLoaded", function () {
    // Form elements
    const form = document.getElementById("company-profile-form");
    const headOfficeProvince = document.getElementById("head_office_province");
    const headOfficeCity = document.getElementById("head_office_city");
    const operationalProvince = document.getElementById("operational_province");
    const operationalCity = document.getElementById("operational_city");

    // Validation rules
    const rules = {
        company_name: {
            required: true,
            minLength: 3,
            maxLength: 255,
        },
        business_type: {
            required: true,
            minLength: 3,
        },
        employee_count: {
            required: true,
            min: 1,
            number: true,
        },
        established_year: {
            required: true,
            min: 1900,
            max: new Date().getFullYear(),
            number: true,
        },
        contact_phone: {
            required: true,
            pattern: /^[\d\-+()]{10,20}$/,
        },
        contact_email: {
            required: true,
            email: true,
        },
    };

    // Load Provinces
    async function loadProvinces(selectElement) {
        try {
            const response = await fetch("/api/provinces");
            const provinces = await response.json();

            selectElement.innerHTML =
                '<option value="">Pilih Provinsi</option>';
            provinces.forEach((province) => {
                const option = document.createElement("option");
                option.value = province.id;
                option.textContent = province.name;
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error("Error loading provinces:", error);
        }
    }

    // Load Cities
    async function loadCities(provinceId, citySelect) {
        try {
            const response = await fetch(`/api/cities/${provinceId}`);
            const cities = await response.json();

            citySelect.innerHTML =
                '<option value="">Pilih Kota/Kabupaten</option>';
            cities.forEach((city) => {
                const option = document.createElement("option");
                option.value = city.id;
                option.textContent = `${city.type} ${city.name}`;
                citySelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error loading cities:", error);
        }
    }

    // Initialize province selectors
    loadProvinces(headOfficeProvince);
    loadProvinces(operationalProvince);

    // Province change handlers
    headOfficeProvince.addEventListener("change", function () {
        loadCities(this.value, headOfficeCity);
    });

    operationalProvince.addEventListener("change", function () {
        loadCities(this.value, operationalCity);
    });

    // Form validation
    function validateField(input, rules) {
        const value = input.value.trim();
        const errors = [];

        if (rules.required && !value) {
            errors.push("Field ini wajib diisi");
        }

        if (value) {
            if (rules.minLength && value.length < rules.minLength) {
                errors.push(`Minimal ${rules.minLength} karakter`);
            }

            if (rules.maxLength && value.length > rules.maxLength) {
                errors.push(`Maksimal ${rules.maxLength} karakter`);
            }

            if (rules.number && isNaN(value)) {
                errors.push("Harus berupa angka");
            }

            if (rules.min && Number(value) < rules.min) {
                errors.push(`Minimal ${rules.min}`);
            }

            if (rules.max && Number(value) > rules.max) {
                errors.push(`Maksimal ${rules.max}`);
            }

            if (rules.email && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                errors.push("Email tidak valid");
            }

            if (rules.pattern && !value.match(rules.pattern)) {
                errors.push("Format tidak valid");
            }
        }

        return errors;
    }

    // Show validation message
    function showError(input, errors) {
        const errorDiv = input.nextElementSibling;
        if (errors.length > 0) {
            errorDiv.textContent = errors.join(", ");
            errorDiv.classList.remove("hidden");
            input.classList.add("border-red-500");
        } else {
            errorDiv.classList.add("hidden");
            input.classList.remove("border-red-500");
        }
    }

    // Real-time validation
    Object.keys(rules).forEach((fieldName) => {
        const input = document.getElementById(fieldName);
        if (input) {
            input.addEventListener("blur", function () {
                const errors = validateField(this, rules[fieldName]);
                showError(this, errors);
            });
        }
    });

    // Form submit handler
    form.addEventListener("submit", function (e) {
        let hasErrors = false;

        // Validate all fields
        Object.keys(rules).forEach((fieldName) => {
            const input = document.getElementById(fieldName);
            if (input) {
                const errors = validateField(input, rules[fieldName]);
                showError(input, errors);
                if (errors.length > 0) hasErrors = true;
            }
        });

        // Validate province and city selections
        if (!headOfficeProvince.value || !headOfficeCity.value) {
            hasErrors = true;
            alert("Pilih Provinsi dan Kota untuk Kantor Pusat");
        }

        if (!operationalProvince.value || !operationalCity.value) {
            hasErrors = true;
            alert("Pilih Provinsi dan Kota untuk Unit Operasional");
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
});
