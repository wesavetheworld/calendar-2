<?php

namespace Solution10\Calendar;

use DateTime;

/**
 * Class Calendar
 *
 * This is the starting point of your Calendars, everything comes from these instances.
 *
 * @package     Solution10\Calendar
 * @author      Alex Gisby <alex@solution10.com>
 * @license     MIT
 */
class Calendar
{
    /**
     * @var     DateTime    The current date expressed as a DateTime instance.
     */
    protected $currentDateTime;

    /**
     * @var     ResolutionInterface     The Resolution for this calendar to work to
     */
    protected $resolution;

    /**
     * @var     EventInterface[]     Events that have been added to the calendar
     */
    protected $events = array();

    /**
     * You can pass the current date in here:
     *
     * @param   DateTime|null    $dateTime
     */
    public function __construct(DateTime $dateTime = null)
    {
        if ($dateTime !== null) {
            $this->setCurrentDate($dateTime);
        }
    }

    /**
     * Sets the current date
     *
     * @param   DateTime    $dateTime
     * @return  $this
     * @throws  Exception\Date          Thrown when date is invalid.
     */
    public function setCurrentDate(DateTime $dateTime)
    {
        $this->currentDateTime = clone $dateTime;
        return $this;
    }

    /**
     * Gets the current date of the Calendar.
     *
     * @return  DateTime
     */
    public function currentDate()
    {
        return $this->currentDateTime;
    }

    /**
     * ---------------------- Display Options ---------------------
     */

    /**
     * Sets the Resolution of the Calendar. Resolutions decide how
     * many months to show either side, or whether to show a week
     * or work week.
     *
     * @param   ResolutionInterface    $res    Resolution to use
     * @return  $this
     */
    public function setResolution(ResolutionInterface $res)
    {
        $this->resolution = $res;
        $this->resolution->setDateTime($this->currentDate());
        return $this;
    }

    /**
     * Returns the Resolution of this calendar.
     *
     * @return  ResolutionInterface
     */
    public function resolution()
    {
        return $this->resolution;
    }

    /*
     * --------------------- Events Functions --------------------
     */

    /**
     * Adding an event to the calendar
     *
     * @param   EventInterface   $event  The event to add
     * @return  $this
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
        return $this;
    }

    /**
     * Returns all of the events for the calendar
     *
     * @return  EventInterface[]
     */
    public function events()
    {
        return $this->events;
    }

    /*
     * -------------------- Rendering Functions ------------------
     */

    /**
     * Returns the data for your templating system to render the calendar.
     *
     * @return  array
     */
    public function viewData()
    {
        $resolutionData = $this->resolution->build();
        return array(
            'contents' => $resolutionData
        );
    }
}
