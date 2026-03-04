Attribute VB_Name = "moduloRelatorios"
Option Explicit

' Define color constants (RGB values)
Const COLOR_PROJETOS_LIGHT As Long = RGB(255, 255, 153) ' Light yellow
Const COLOR_PROJETOS_STRONG As Long = RGB(255, 255, 0)  ' Strong yellow
Const COLOR_CONFERENCIA_LIGHT As Long = RGB(173, 216, 230) ' Light blue
Const COLOR_CONFERENCIA_STRONG As Long = RGB(0, 0, 255)   ' Strong blue
' Add more colors for other sectors as needed

Sub UpdateGanttChart()
    Dim ws As Worksheet
    Set ws = ThisWorkbook.Sheets("Gantt") ' Assume sheet name is "Gantt"
    
    Dim lastRow As Long
    lastRow = ws.Cells(ws.Rows.Count, "A").End(xlUp).Row
    
    Dim lastCol As Long
    lastCol = ws.Cells(1, ws.Columns.Count).End(xlToLeft).Column
    
    Dim today As Date
    today = Date
    
    Dim i As Long, j As Long
    Dim startDate As Date, endDate As Date
    Dim sector As String
    Dim cellDate As Date
    Dim color As Long
    
    For i = 2 To lastRow ' Assuming row 1 is headers
        startDate = ws.Cells(i, 2).Value ' Column B: start date
        endDate = ws.Cells(i, 3).Value   ' Column C: end date
        sector = ws.Cells(i, 4).Value    ' Column D: sector
        
        For j = 5 To lastCol ' Assuming columns E+ are dates
            cellDate = ws.Cells(1, j).Value ' Row 1: dates
            
            If cellDate >= startDate And cellDate <= endDate Then
                ' Only color if not already colored (to preserve past colors)
                If ws.Cells(i, j).Interior.Color = xlNone Then
                    Select Case sector
                        Case "PROJETOS"
                            If cellDate <= today Then
                                color = COLOR_PROJETOS_LIGHT
                            Else
                                color = COLOR_PROJETOS_STRONG
                            End If
                        Case "CONFERENCIA"
                            If cellDate <= today Then
                                color = COLOR_CONFERENCIA_LIGHT
                            Else
                                color = COLOR_CONFERENCIA_STRONG
                            End If
                        ' Add cases for other sectors
                        Case Else
                            color = RGB(200, 200, 200) ' Default gray
                    End Select
                    
                    ws.Cells(i, j).Interior.Color = color
                End If
            End If
        Next j
    Next i
End Sub

Sub SetupGanttSheet()
    Dim ws As Worksheet
    Set ws = ThisWorkbook.Sheets.Add
    ws.Name = "Gantt"
    
    ' Setup headers
    ws.Cells(1, 1).Value = "Task"
    ws.Cells(1, 2).Value = "Start Date"
    ws.Cells(1, 3).Value = "End Date"
    ws.Cells(1, 4).Value = "Sector"
    
    ' Example data
    ws.Cells(2, 1).Value = "Task 1"
    ws.Cells(2, 2).Value = Date - 10
    ws.Cells(2, 3).Value = Date + 10
    ws.Cells(2, 4).Value = "PROJETOS"
    
    ' Add dates in row 1 from column 5 onwards
    Dim startDate As Date
    startDate = Date - 15
    Dim col As Long
    For col = 5 To 35 ' Adjust as needed
        ws.Cells(1, col).Value = startDate
        startDate = startDate + 1
    Next col
    
    ' Format dates
    ws.Rows(1).NumberFormat = "dd/mm/yyyy"
    ws.Columns(2).NumberFormat = "dd/mm/yyyy"
    ws.Columns(3).NumberFormat = "dd/mm/yyyy"
    
    ' Call update
    UpdateGanttChart
End Sub
