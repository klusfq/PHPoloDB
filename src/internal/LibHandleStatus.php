<?php

namespace Pholur\Internal;

enum LibHandleStatus: int
{
    case Halt = -1;
    case Init = 0;
    case Running = 1;
    case HasRow = 2;
}
