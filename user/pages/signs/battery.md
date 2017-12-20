# Usage of the battery system

Please try to leave the battery _fully_ charged at all times!

## Detecting charging state of the battery

The battery is (nearly) fully charged when one of the following is true:

  * Voltage above 14.0 V AND current below 3 A
  * Voltage above 13.5 V AND current below 1 A

When it is dark and only little power (e.g. 1 light) is drawn, the charging state is as follows:

  * Nearly full: Voltage > 12.6 V
  * Half empty: Voltage ~ 12.1 V
  * STOP USAGE: Voltage ~ 11.7 V

## How is the lifetime of these batteries?

Lead acid batteries like these ones here take damage from

  * Not beeing fully charged: Leave it standing empty for a year and you can throw it away. Interpolation (regarding state-of-charge as well as time) can be done lineary :)
  * Being cycled/used: This is a bit harder.
    * Do full-cycles (Charge fully/discharge fully) and you can throw it away after 10-20 cycles.
    * Do half-cycles (Charge fully, discharge down to 50%/12V) and you can throw it away after 50-100 full cycles (translating to 100-200 of these half-cycles).
    * Do smaller cycles (charge fully, discharge only 5-10%) and it will last for thousands of these (typical use case in car)
