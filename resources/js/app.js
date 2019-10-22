require('./bootstrap');

(() => {
    const calendar = document.querySelector('.js-calendar');
    if (calendar) {
        const selectDate = document.querySelector('.js-select_date');
        const monthNames = calendar.querySelectorAll('.js-calendar_header');
        const months = calendar.querySelectorAll('.js-calendar-month_item');
        const closeBtn = calendar.querySelector('.js-calendar-close');
        let today = calendar.querySelector('.calendar-selected');
        let startingName = monthNames[0];
        let startingMonth = months[0];
        const selectBtn = calendar.querySelector('.js-calendar-set_day');
        const hidden = document.querySelector('.js-form-hidden_input');

        startingName.classList.add('calendar-header--active');
        startingMonth.classList.add('calendar-month_item--active');

        const showCalendar = () => {
            calendar.classList.add('calendar--active');
        };

        const close = () => {
            const activeDay = calendar.querySelector('.calendar-selected');
            const activeName = calendar.querySelector('.calendar-header--active');
            const activeMonth = calendar.querySelector('.calendar-month_item--active');
            activeDay.classList.remove('calendar-selected');
            today.classList.add('calendar-selected');
            activeName.classList.remove('calendar-header--active');
            activeMonth.classList.remove('calendar-month_item--active');
            startingName.classList.add('calendar-header--active');
            startingMonth.classList.add('calendar-month_item--active');
            calendar.classList.remove('calendar--active');
        };

        const hideCalendar = e => {
            if (e.currentTarget === e.target
                || e.key === "Escape"
                || e.key === "Esc"
                || e.target.closest('.js-calendar-close')
            ) {
                close();
            }
        };

        const nextMonth = e => {
            if (e.target.closest('.js-calendar-select_month_btn')) {
                const direction = e.target.closest('.js-calendar-select_month_btn').dataset.direction;

                const activeName = calendar.querySelector('.calendar-header--active');
                const activeMonth = calendar.querySelector('.calendar-month_item--active');
                const nextName = direction === 'next' ? activeName.nextElementSibling : activeName.previousElementSibling;
                const nextMonth = direction === 'next' ? activeMonth.nextElementSibling : activeMonth.previousElementSibling;

                if (nextName && nextMonth) {
                    const selected = calendar.querySelector('.calendar-selected');
                    const date = selected.dataset.date;
                    activeName.classList.remove('calendar-header--active');
                    activeMonth.classList.remove('calendar-month_item--active');
                    nextName.classList.add('calendar-header--active');
                    nextMonth.classList.add('calendar-month_item--active');
                    const newDay = nextMonth.querySelector('.js-calendar-select[data-date="' + date + '"]');

                    if (newDay) {
                        calendar.querySelectorAll('.calendar-selected')
                            .forEach(item => item.classList.remove('calendar-selected'));
                        newDay.classList.add('calendar-selected');
                    }
                }
            }
        };

        const chooseDay = e => {
            const parent = e.target.closest('.js-calendar-day');
            if (parent) {
                const day = parent.querySelector('.js-calendar-select');
                if (day) {
                    const newAttribute = day.dataset.date;
                    const newMonth = (new Date(newAttribute).getMonth()) + 1;
                    const currentMonth = calendar.querySelector('.calendar-month_item--active').dataset.month;
                    const activeName = calendar.querySelector('.calendar-header--active');
                    const activeMonth = calendar.querySelector('.calendar-month_item--active');

                    let nextName = null;
                    let nextMonth = null;

                    if (currentMonth != newMonth) {
                        nextName = currentMonth > newMonth ? activeName.previousElementSibling : activeName.nextElementSibling;
                        nextMonth = currentMonth > newMonth ? activeMonth.previousElementSibling : activeMonth.nextElementSibling;

                        if (nextName && nextMonth) {
                            activeName.classList.remove('calendar-header--active');
                            activeMonth.classList.remove('calendar-month_item--active');
                            nextName.classList.add('calendar-header--active');
                            nextMonth.classList.add('calendar-month_item--active');
                            calendar.querySelectorAll('.calendar-selected')
                                .forEach(item => item.classList.remove('calendar-selected'));
                            const newDay = nextMonth.querySelector('.js-calendar-select[data-date="' + newAttribute + '"]');
                            newDay.classList.add('calendar-selected');
                        }
                    } else {
                        calendar.querySelectorAll('.calendar-selected')
                            .forEach(item => item.classList.remove('calendar-selected'));
                        day.classList.add('calendar-selected');
                    }
                }
            }
        };

        const setDay = () => {
            const selected = calendar.querySelector('.calendar-selected');
            const date = selected.dataset.date;
            hidden.value = date;
            const dateInstanse = new Date(date);
            const month = dateInstanse.getMonth() + 1 < 10 ? '0' + (dateInstanse.getMonth() + 1) : dateInstanse.getMonth() + 1;
            selectDate.textContent = `${dateInstanse.getDate()}.${month}.${dateInstanse.getFullYear()}`;
            startingName = calendar.querySelector('.calendar-header[data-monthname="' + (dateInstanse.getMonth() + 1) + '"]');
            startingMonth = calendar.querySelector('.calendar-month_item[data-month="' + (dateInstanse.getMonth() + 1) + '"]');
            today = startingMonth.querySelector('.js-calendar-select[data-date="' + date + '"]');
            close();
        };

        selectDate.addEventListener('click', showCalendar);
        calendar.addEventListener('click', hideCalendar);
        document.addEventListener('keydown', hideCalendar);
        closeBtn.addEventListener('click', hideCalendar);
        calendar.addEventListener('click', nextMonth);
        calendar.addEventListener('click', chooseDay);
        selectBtn.addEventListener('click', setDay);
    }
})();

(() => {
    const searchCityInputs = document.querySelectorAll('.js-form-search_city');

    if (searchCityInputs) {

        const cityLists = document.querySelectorAll('.js-form-city_list');

        const search = async name => {
            const citiesJson = await fetch(`/ajax/city/${name}`, {
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            });
            return await citiesJson.json();
        };

        const searchCity = e => {
            const target = e.target;
            const cityList = target.closest('.js-form-input_group').querySelector('.js-form-city_list');

            const close = () => {
                cityList.classList.remove('js-form-city_list--active');
                cityList.textContent = '';
            };

            if (target.value.length < 4) {
                close();
                return;
            }

            search(target.value.toLowerCase()).then(value => {
                if (value.length === 0) {
                    close();
                    return;
                }

                cityList.textContent = '';

                const fragment = document.createDocumentFragment();

                value.forEach(city => {
                    const li = document.createElement('li');
                    li.classList.add('form-city_item');
                    li.textContent = `${city[0].toUpperCase()}${city.slice(1)}`;
                    fragment.appendChild(li);
                });

                cityList.appendChild(fragment);

                if (! cityList.classList.contains('js-form-city_list--active')) {
                    cityList.classList.add('js-form-city_list--active');
                }

                setTimeout(() => {
                    if (target.value.length < 4) {
                        close();
                    }
                }, 100);
            });
        };

        const closeCityList = e => {
            if (!e.target.closest('.js-form-city_list--active')
                || e.key === "Escape"
                || e.key === "Esc"
            ) {
                const list = document.querySelector('.js-form-city_list--active');
                if (list) {
                    list.classList.remove('js-form-city_list--active');
                }
            }
        };

        const setCity = e => {
            const target = e.target;

            if (target.classList.contains('form-city_item')) {
                const input = target.closest('.js-form-input_group').querySelector('.js-form-search_city');
                input.value = target.textContent;
                target.closest('.js-form-city_list--active').classList.remove('js-form-city_list--active');
            }
        };

        searchCityInputs.forEach(input => input.addEventListener('input', searchCity));
        cityLists.forEach(list => list.addEventListener('click', setCity));
        document.addEventListener('click', closeCityList);
        document.addEventListener('keydown', closeCityList);
    }
})();

(() => {
    const inputs = [...document.querySelectorAll('.js-input')];

    inputs.forEach(input => input.addEventListener('focus', e => {
        const target = e.currentTarget;
        const parent = target.closest('.is-invalid');
        if (parent) {
            parent.classList.remove('is-invalid');
            target.value = '';
            parent.removeChild(parent.querySelector('.form-error_message'));
        }
    }));
})();


(() => {
    const time = document.querySelector('.time');

    if (time) {
        const timeInput = document.querySelector('.js-select_time');
        const hiddenInput = document.querySelector('.js-form-hidden_time');
        const hours = time.querySelector('.js-time-hours');
        const minutes = time.querySelector('.js-time-minutes');
        const groups = time.querySelectorAll('.js-time-input_group');
        const setTimeBtn = time.querySelector('.js-time-set_time');

        let inputValue = '00';

        const onInput = e => {
            const target = e.currentTarget;

            if (target.classList.contains('time-input--error')) {
                target.classList.remove('time-input--error');
            }
            const max = parseInt(target.dataset.max);

            if (target.value === '') {
                return;
            }

            const value = parseInt(target.value);

            if (! /^\d*$/.test(target.value) || value > max || target.value.length > 2) {
                target.value = inputValue;
                return;
            }

            inputValue = target.value;
            target.value = inputValue;
        };

        const onChange = e => {
            const value = e.currentTarget.value;

            if (value === '') {
                e.currentTarget.value = '00';
                return;
            }

            if (parseInt(e.currentTarget.value) < 10 && value.length < 2) {
                e.currentTarget.value = '0' + value;
            }
        };

        const onBtnClick = e => {
            const target = e.target;
            const btn = target.closest('.js-time-btn');

            if (btn) {
                const direction = btn.dataset.direction;
                const input = e.target.closest('.js-time-input_group').querySelector('input');

                if (input.classList.contains('time-input--error')) {
                    input.classList.remove('time-input--error');
                }

                const max = parseInt(input.dataset.max);
                let value = input.value === '' ? 0 : parseInt(input.value);

                if (direction === 'up' && value === max) {
                    value = 0;
                } else if (direction === 'down' && value === 0) {
                    value = max;
                } else {
                    direction === 'up' ? value++ : value--;
                }

                input.value = value < 10 ? '0' + value : value;
            }
        };

        const onSetTime = () => {
            groups.forEach(group => {
                const input = group.querySelector('input');

                if (input.value === '') {
                    input.classList.add('time-input--error');
                    return;
                }

                timeInput.textContent = hours.value + ':' + minutes.value;
                hiddenInput.value = hours.value + ':' + minutes.value + ':00';
                time.classList.remove('time--active');
            });
        };

        timeInput.addEventListener('click', () => time.classList.add('time--active'));
        hours.addEventListener('input', onInput);
        minutes.addEventListener('input', onInput);
        hours.addEventListener('change', onChange);
        minutes.addEventListener('change', onChange);
        groups.forEach(group => group.addEventListener('click', onBtnClick));
        setTimeBtn.addEventListener('click', onSetTime);
    }
})();

(() => {
    const table = document.querySelector('.table');

    if (table) {
        const popup = document.querySelector('.js-delete_ticket');

        const removeTicket = e => {
            if (e.target.classList.contains('js-table-remove')) {
                const url = e.target.dataset.url;

                popup.classList.add('delete_ticket--active');
                popup.querySelector('.js-delete_ticket_form').setAttribute('action', url);
            }
        };

        const close = e => {
            if (e.target.closest('.js-delete_ticket-close')
                || e.target.classList.contains('js-delete_ticket')
                || e.key === "Escape"
                || e.key === "Esc"
            ) {
                popup.classList.remove('delete_ticket--active');
            }
        };

        table.addEventListener('click', removeTicket);
        document.addEventListener('click', close);
        document.addEventListener('keydown', close);
    }
})();