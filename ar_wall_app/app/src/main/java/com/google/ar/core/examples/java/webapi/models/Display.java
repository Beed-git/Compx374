package com.google.ar.core.examples.java.webapi.models;

public class Display {
    public int id;
    public String name;
    public String description;
    public int moderatorId;
    public int competitionId;

    @Override
    public String toString() {
        return String.format("%d\n%s\n%s\n%d\n%d", id, name, description, moderatorId, competitionId);
    }
}
